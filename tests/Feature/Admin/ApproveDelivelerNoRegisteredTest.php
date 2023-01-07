<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use DatabaseMigrations;
use Illuminate\Support\Facades\DB;

class ApproveDelivelerNoRegisteredTest extends TestCase
{
    use RefreshDatabase;
    public function setup(): void {
        parent::setup();
        $this->insertNecessaryTestData();
    }

    public function insertNecessaryTestData() {
        DB::table('user_examinations')->insert([
            'id' => 1,
            'last_name' => 'lastName1',
            'first_name' => 'firstName1',
            'phone' => '080-0808-0801',
            'email' => 'validate1@email.com',
            'category' => '金融',
            'site_domein' => 'aaaaa1.com',
            'review_flag' => 0,
        ]);
        DB::table('user_examinations')->insert([
            'id' => 2,
            'last_name' => 'lastName2',
            'first_name' => 'firstName2',
            'phone' => '080-0808-0802',
            'email' => 'validate2@email.com',
            'category' => '金融',
            'site_domein' => 'aaaaa2.com',
            'review_flag' => 1,
        ]);
        DB::table('user_examinations')->insert([
            'id' => 3,
            'last_name' => 'lastName3',
            'first_name' => 'firstName3',
            'phone' => '080-0808-0830',
            'email' => 'validate3@email.com',
            'category' => '金融',
            'site_domein' => 'aaaaa3.com',
            'review_flag' => 2,
        ]);
        
    }

    public function runApi($userExaminationId, $expectedResponse, $reviewFlag = null, $statusCode = 200) {
        $response = $this->post("/api/approve-deliveler-form", ['userExaminationId' => $userExaminationId]);

        $response->assertStatus($statusCode);

        if ($reviewFlag) {
            $userExamination = DB::table('user_examinations')->where('id', $userExaminationId)->first();
            $this->assertEquals($reviewFlag, $userExamination->review_flag);
        }

        $response->assertJsonFragment($expectedResponse);        
    }

    /**
     * Summary of test_正常
     * @return void
     */
    public function test_正常()
    {
        $userExaminationId = 1;
        $reviewFlag = 1;
        
        $expectedResponse = [
            'id' => 1,
            'examinationId' => 1,
            'lastName' => 'lastName1',
            'firstName' => 'firstName1',
            'email' => 'validate1@email.com',
            'phone' => '080-0808-0801',
            'zipcode' => null,
            'address' => null,
            'paymentWay' => 0,
            'budget' => 0,
            'isStopped' => 0,
            'isRetire' => 0,
        ];

        $this->runApi($userExaminationId, $expectedResponse, $reviewFlag);
    }

    public function test_パラメータなし() {
        $userExaminationId = '';

        $expectedReponse = [
            'message' => '仮登録IDは必須です。',
        ];

        $this->runApi($userExaminationId, $expectedReponse, null, 404);
    }

    public function test_存在しないID() {
        $userExaminationId = 100;

        $expectedReponse = [
            'message' => '存在しない仮登録IDです。',
        ];

        $this->runApi($userExaminationId, $expectedReponse, null, 400);
    }

    public function test_承認済み() {
        $userExaminationId = 2;
        $reviewFlag = 1;

        $expectedReponse = [
            'message' => '審査済みです。',
        ];

        $this->runApi($userExaminationId, $expectedReponse, $reviewFlag, 400);
    }

    public function test_非承認済み() {
        $userExaminationId = 3;
        $reviewFlag = 2;

        $expectedReponse = [
            'message' => '審査済みです。',
        ];

        $this->runApi($userExaminationId, $expectedReponse, $reviewFlag, 400);
    }
}
