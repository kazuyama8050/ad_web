<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use DatabaseMigrations;
use Illuminate\Support\Facades\DB;
use Tests\Helper\UserExaminationTrait;
use Tests\Helper\UserTrait;
use App\Models\User\User;

class LoginUserTest extends TestCase
{
    use RefreshDatabase;
    use UserExaminationTrait;
    use UserTrait;

    public function setup(): void {
        parent::setup();
        $this->insertNecessaryTestData();
    }

    public function insertNecessaryTestData() {

        for ($i=1;$i<=4;$i++) {
            UserExaminationTrait::insertDefaultUserExaminationData($i);
        }
        
        UserTrait::insertDefaultUserData(1, $password = 'test1', $isStopped = 0, $isRetire = 0);
        UserTrait::insertDefaultUserData(2, $password = 'test2', $isStopped = 1, $isRetire = 0);
        UserTrait::insertDefaultUserData(3, $password = 'test3', $isStopped = 0, $isRetire = 1);
    }

    public function runApi($requestBody, $expectedResponse, $statusCode = 200) {
        $response = $this->post("/api/login-user", $requestBody);

        $response->assertStatus($statusCode);
        if ($statusCode == 200) {
            $sessionEmail = session()->get('userEmail');
            $sessionId = session()->get('userId');
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
            'email' => "validate1@email.com",
            'password' => "test1"
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
            'password' => "test1"
        ];

        $expectedResponse = [
            'message' => 'メールアドレスは必須です。',
        ];

        $this->runApi($requestBody, $expectedResponse, 404);
    }
    public function test_パスワードなし()
    {

        $requestBody = [
            'email' => "validate1@email.com",
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
            'email' => "validate100@email.com",
            'password' => "test1"
        ];

        $expectedResponse = [
            'message' => '登録されていないメールアドレスです。',
        ];

        $this->runApi($requestBody, $expectedResponse, 400);
    }
    public function test_パスワード不整合()
    {

        $requestBody = [
            'email' => "validate1@email.com",
            'password' => "test100"
        ];

        $expectedResponse = [
            'message' => 'パスワードが一致しません。',
        ];

        $this->runApi($requestBody, $expectedResponse, 400);
    }
    public function test_アカウント停止中()
    {

        $requestBody = [
            'email' => "validate2@email.com",
            'password' => "test2"
        ];

        $expectedResponse = [
            'message' => '停止中のアカウントです。',
        ];

        $this->runApi($requestBody, $expectedResponse, 400);
    }
    public function test_アカウント退会済み()
    {

        $requestBody = [
            'email' => "validate3@email.com",
            'password' => "test3"
        ];

        $expectedResponse = [
            'message' => '退会済みのアカウントです。',
        ];

        $this->runApi($requestBody, $expectedResponse, 400);
    }

}
