<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use DatabaseMigrations;
use Illuminate\Support\Facades\DB;
use Tests\Helper\AdminLoginTrait;

class GetAllUserTest extends TestCase
{
    use RefreshDatabase;
    use AdminLoginTrait;
    public function setup(): void {
        parent::setup();
        $this->insertNecessaryTestData();
    }

    public function insertNecessaryTestData() {

        for ($i = 1; $i <= 4;$i++) {
            DB::table('user_examinations')->insert([
                'last_name' => "lastName$i",
                'first_name' => "firstName$i",
                'phone' => "080-0808-0801$i",
                'email' => "validate1@email.com$i",
                'category' => "金融",
                'site_domein' => "aaaaa$i.com",
                'review_flag' => 1,
            ]);
        }

        DB::table('users')->insert([
            'examination_id' => 1,
            'last_name' => 'lastName1',
            'first_name' => 'firstName1',
            'password' => 'aaxsxs',
            'phone' => '080-0808-0801',
            'email' => 'validate1@email.com',
            'zipcode' => '000-0000',
            'address' => '東京都日野市',
            'is_stopped' => 0,
            'is_retire' => 0,
        ]);
        
        DB::table('users')->insert([
            'examination_id' => 2,
            'last_name' => 'lastName2',
            'first_name' => 'firstName2',
            'password' => 'aaxsxs',
            'phone' => '080-0808-0802',
            'email' => 'validate2@email.com',
            'zipcode' => '000-0002',
            'address' => '東京都日野市2',
            'is_stopped' => 0,
            'is_retire' => 0,
        ]);
        
        DB::table('users')->insert([
            'examination_id' => 3,
            'last_name' => 'lastName3',
            'first_name' => 'firstName3',
            'password' => 'aaxsxs',
            'phone' => '080-0808-0803',
            'email' => 'validate3@email.com',
            'zipcode' => '000-0003',
            'address' => '東京都日野市3',
            'is_stopped' => 1,
            'is_retire' => 0,
        ]);
        
        DB::table('users')->insert([
            'examination_id' => 4,
            'last_name' => 'lastName4',
            'first_name' => 'firstName4',
            'password' => 'aaxsxs',
            'phone' => '080-0808-0804',
            'email' => 'validate4@email.com',
            'zipcode' => '000-0004',
            'address' => '東京都日野市4',
            'is_stopped' => 0,
            'is_retire' => 1,
        ]);
        
    }
    /**
     * Summary of test_正常
     * @return void
     */
    public function test_正常()
    {
        AdminLoginTrait::adminLogin();
        $response = $this->get('/api/all-user');
        $response->assertStatus(200);

        $responseBody = $response->decodeResponseJson();

        $response->assertJsonFragment([
            'id' => 1,
            'examinationId' => 1,
            'lastName' => 'lastName1',
            'firstName' => 'firstName1',
            'phone' => '080-0808-0801',
            'email' => 'validate1@email.com',
            'zipcode' => '000-0000',
            'address' => '東京都日野市',
            'isStopped' => 0,
            'isRetire' => 0,
        ]);
        $response->assertJsonFragment([
            'id' => 2,
            'examinationId' => 2,
            'lastName' => 'lastName2',
            'firstName' => 'firstName2',
            'phone' => '080-0808-0802',
            'email' => 'validate2@email.com',
            'zipcode' => '000-0002',
            'address' => '東京都日野市2',
            'isStopped' => 0,
            'isRetire' => 0,
        ]);

        session()->flush();

    }
}
