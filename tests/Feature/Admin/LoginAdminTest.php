<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use DatabaseMigrations;
use Illuminate\Support\Facades\DB;
use Tests\Helper\AdminTrait;
use App\Models\Admin\Admin;

class LoginAdminTest extends TestCase
{
    use RefreshDatabase;
    use AdminTrait;

    public function setup(): void {
        parent::setup();
        $this->insertNecessaryTestData();
    }

    public function insertNecessaryTestData() {
        AdminTrait::insertDefaultAdminData(1, $password = 'test');
        AdminTrait::insertDefaultAdminData(2, $password = 'test2');
        AdminTrait::insertDefaultAdminData(3, $password = 'test3');
    }

    public function runApi($requestBody, $expectedResponse, $statusCode = 200) {
        $response = $this->post("/api/login-admin", $requestBody);

        $response->assertStatus($statusCode);
        if ($statusCode == 200) {
            $sessionEmail = session()->get('adminEmail');
            $sessionId = session()->get('adminId');
            $this->assertEquals($requestBody['email'], $sessionEmail);
        }

        $response->assertJsonFragment($expectedResponse);
        session()->flush();
    }

    /**
     * Summary of test_正常
     * @return void
     */
    public function test_正常()
    {

        $requestBody = [
            'email' => "admin1@email.com",
            'password' => "test"
        ];

        $expectedResponse = [
            'message' => 'OK',
        ];

        $this->runApi($requestBody, $expectedResponse);
    }
    public function test_メールアドレスなし()
    {

        $requestBody = [
            'email' => "",
            'password' => "test"
        ];

        $expectedResponse = [
            'message' => 'メールアドレスは必須です。',
        ];

        $this->runApi($requestBody, $expectedResponse, 404);
    }
    public function test_パスワードなし()
    {

        $requestBody = [
            'email' => "admin1@email.com",
            'password' => ""
        ];

        $expectedResponse = [
            'message' => 'パスワードは必須です。',
        ];

        $this->runApi($requestBody, $expectedResponse, 404);
    }
    public function test_メールアドレス不整合()
    {

        $requestBody = [
            'email' => "admin100@email.com",
            'password' => "test"
        ];

        $expectedResponse = [
            'message' => '登録されていないメールアドレスです。',
        ];

        $this->runApi($requestBody, $expectedResponse, 400);
    }
    public function test_パスワード不整合()
    {

        $requestBody = [
            'email' => "admin1@email.com",
            'password' => "test00"
        ];

        $expectedResponse = [
            'message' => 'パスワードが一致しません。',
        ];

        $this->runApi($requestBody, $expectedResponse, 400);
    }

}
