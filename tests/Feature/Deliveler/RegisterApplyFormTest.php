<?php

namespace Tests\Feature\Deliveler;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use DatabaseMigrations;
use Illuminate\Support\Facades\DB;

class RegisterApplyFormTest extends TestCase
{
    use RefreshDatabase;
    public function setup(): void {
        parent::setup();
        $this->insertNecessaryData();
    }

    public function insertNecessaryData() {
        DB::table('user_examinations')->insert([
            'last_name' => 'lastName1',
            'first_name' => 'firstName1',
            'phone' => '080-0808-0808',
            'email' => 'validate@email.com',
            'category' => '金融',
            'site_domein' => 'aaaaa.com',
            'review_flag' => 1,
        ]);
    }

    public function runApi($requestBody, $responseBody, $statusCode = 200) {
        $response = $this->post('/api/register-deliveler-form', $requestBody);

        $response->assertStatus($statusCode);

        $response->assertJsonFragment($responseBody);
        
    }

    /**
     * Summary of test_正常
     * @return void
     */
    public function test_正常()
    {
        $requestBody = [
            'lastName' => '田中',
            'firstName' => '太郎',
            'phone' => '000-0000-0000',
            'email' => 'kazuki118050@gmail.com',
            'siteDomein' => 'aaaaa.com',
            'category' => '金融',
        ];
        
        $responseBody = [
            'lastName' => '田中',
            'firstName' => '太郎',
            'email' => 'kazuki118050@gmail.com',
            'phone' => '000-0000-0000',
            'category' => '金融',
            'siteDomein' => 'aaaaa.com',
            'reviewFlag' => 0,
        ];

        $this->runApi($requestBody, $responseBody);
    }

    public function test_email重複() {
        $requestBody = [
            'lastName' => '田中',
            'firstName' => '太郎',
            'phone' => '000-0000-0001',
            'email' => 'validate@email.com',
            'siteDomein' => 'aaaaa.com',
            'category' => '金融',
        ];
        
        $responseBody = [
            'message' => '登録済みのメールアドレスです。',
        ];

        $this->runApi($requestBody, $responseBody, 400);
    }

    public function test_phone重複() {
        $requestBody = [
            'lastName' => '田中',
            'firstName' => '太郎',
            'phone' => '080-0808-0808',
            'email' => 'test03@email.com',
            'siteDomein' => 'aaaaa.com',
            'category' => '金融',
        ];
        
        $responseBody = [
            'message' => '登録済みの電話番号です。',
        ];

        $this->runApi($requestBody, $responseBody, 400);
    }

    public function test_lastNameなし() {
        $requestBody = [
            'firstName' => '太郎',
            'phone' => '080-0808-0804',
            'email' => 'test04@email.com',
            'siteDomein' => 'aaaaa.com',
            'category' => '金融',
        ];
        
        $responseBody = [
            'message' => '苗字は必須項目です。',
        ];

        $this->runApi($requestBody, $responseBody, 400);
    }

    public function test_firstNameなし() {
        $requestBody = [
            'lastName' => '太郎',
            'phone' => '080-0808-0805',
            'email' => 'test05@email.com',
            'siteDomein' => 'aaaaa.com',
            'category' => '金融',
        ];
        
        $responseBody = [
            'message' => '名前は必須項目です。',
        ];

        $this->runApi($requestBody, $responseBody, 400);
    }

    public function test_電話番号なし()
    {
        $requestBody = [
            'lastName' => '田中',
            'firstName' => '太郎',
            'email' => 'test06@gmail.com',
            'siteDomein' => 'aaaaa.com',
            'category' => '金融',
        ];
        
        $responseBody = [
            'message' => '電話番号は必須項目です。',
        ];

        $this->runApi($requestBody, $responseBody, 400);
    }

    public function test_メールアドレスなし()
    {
        $requestBody = [
            'lastName' => '田中',
            'firstName' => '太郎',
            'phone' => '000-0000-0007',
            'siteDomein' => 'aaaaa.com',
            'category' => '金融',
        ];
        
        $responseBody = [
            'message' => 'メールアドレスは必須項目です。',
        ];

        $this->runApi($requestBody, $responseBody, 400);
    }

    public function test_サイトドメインなし()
    {
        $requestBody = [
            'lastName' => '田中',
            'firstName' => '太郎',
            'phone' => '000-0000-0008',
            'email' => 'test08@gmail.com',
            'category' => '金融',
        ];
        
        $responseBody = [
            'message' => 'サイトドメインは必須項目です。',
        ];

        $this->runApi($requestBody, $responseBody, 400);
    }

    public function test_カテゴリなし()
    {
        $requestBody = [
            'lastName' => '田中',
            'firstName' => '太郎',
            'phone' => '000-0000-0009',
            'email' => 'test09@gmail.com',
            'siteDomein' => 'aaaaa.com',
        ];
        
        $responseBody = [
            'message' => 'カテゴリは必須項目です。',
        ];

        $this->runApi($requestBody, $responseBody, 400);
    }

    public function test_苗字31文字以上()
    {
        $requestBody = [
            'lastName' => 'ああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああ',
            'firstName' => '太郎',
            'phone' => '000-0000-0010',
            'email' => 'test10@gmail.com',
            'siteDomein' => 'aaaaa.com',
            'category' => '金融',
        ];
        
        $responseBody = [
            'message' => '30文字以内で入力してください。',
        ];

        $this->runApi($requestBody, $responseBody, 400);
    }
    public function test_名前31文字以上()
    {
        $requestBody = [
            'lastName' => '田中',
            'firstName' => 'ああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああ',
            'phone' => '000-0000-0011',
            'email' => 'test11@gmail.com',
            'siteDomein' => 'aaaaa.com',
            'category' => '金融',
        ];
        
        $responseBody = [
            'message' => '30文字以内で入力してください。',
        ];

        $this->runApi($requestBody, $responseBody, 400);
    }
    public function test_電話番号形式不正()
    {
        $requestBody = [
            'lastName' => '田中',
            'firstName' => '太郎',
            'phone' => '00000000000',
            'email' => 'test12@gmail.com',
            'siteDomein' => 'aaaaa.com',
            'category' => '金融',
        ];
        
        $responseBody = [
            'message' => '不正な電話番号の形式です。',
        ];

        $this->runApi($requestBody, $responseBody, 400);
    }

    public function test_メールアドレス形式不正()
    {
        $requestBody = [
            'lastName' => '田中',
            'firstName' => '太郎',
            'phone' => '000-0000-0013',
            'email' => 'test06gmail.com',
            'siteDomein' => 'aaaaa.com',
            'category' => '金融',
        ];
        
        $responseBody = [
            'message' => '不正なメールアドレスの形式です。',
        ];

        $this->runApi($requestBody, $responseBody, 400);
    }
}
