<?php

namespace Tests\Feature\Advertiser;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use DatabaseMigrations;
use Illuminate\Support\Facades\DB;
use Tests\Helper\AdvertiserTrait;
use App\Models\Advertiser\Advertiser;

class LoginAdvertiserTest extends TestCase
{
    use RefreshDatabase;
    use AdvertiserTrait;

    public function setup(): void {
        parent::setup();
        $this->insertNecessaryTestData();
    }

    public function insertNecessaryTestData() {
        AdvertiserTrait::insertDefaultAdvertiserData(1, $password = 'test1', $paymentWay = 0, $budget = 0, $isStopped = 0, $isRetire = 0);
        AdvertiserTrait::insertDefaultAdvertiserData(2, $password = 'test2', $paymentWay = 0, $budget = 0, $isStopped = 1, $isRetire = 0);
        AdvertiserTrait::insertDefaultAdvertiserData(3, $password = 'test3', $paymentWay = 0, $budget = 0, $isStopped = 0, $isRetire = 1);
        $test = DB::table('advertisers')->get();
    }

    public function runApi($requestBody, $expectedResponse, $statusCode = 200) {
        $response = $this->post("/api/login-advertiser", $requestBody);

        $response->assertStatus($statusCode);
        if ($statusCode == 200) {
            $sessionStoreAccount = session()->get('advertiserStoreAccount');
            $sessionId = session()->get('advertiserId');
            $this->assertEquals($requestBody['storeAccount'], $sessionStoreAccount);
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
            'storeAccount' => "store1",
            'password' => "test1"
        ];

        $expectedResponse = [
            'message' => 'OK',
        ];

        $this->runApi($requestBody, $expectedResponse);
    }
    public function test_ストアアカウントなし()
    {

        $requestBody = [
            'storeAccount' => "",
            'password' => "test1"
        ];

        $expectedResponse = [
            'message' => 'ストアアカウントは必須です。',
        ];

        $this->runApi($requestBody, $expectedResponse, 404);
    }
    public function test_パスワードなし()
    {

        $requestBody = [
            'storeAccount' => "store1",
            'password' => ""
        ];

        $expectedResponse = [
            'message' => 'パスワードは必須です。',
        ];

        $this->runApi($requestBody, $expectedResponse, 404);
    }
    public function test_ストアアカウント不整合()
    {

        $requestBody = [
            'storeAccount' => "store100",
            'password' => "test1"
        ];

        $expectedResponse = [
            'message' => '登録されていないストアアカウントです。',
        ];

        $this->runApi($requestBody, $expectedResponse, 400);
    }
    public function test_パスワード不整合()
    {

        $requestBody = [
            'storeAccount' => "store1",
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
            'storeAccount' => "store2",
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
            'storeAccount' => "store3",
            'password' => "test3"
        ];

        $expectedResponse = [
            'message' => '退会済みのアカウントです。',
        ];

        $this->runApi($requestBody, $expectedResponse, 400);
    }

}
