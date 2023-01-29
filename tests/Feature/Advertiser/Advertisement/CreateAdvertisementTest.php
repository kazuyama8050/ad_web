<?php

namespace Tests\Feature\Advertiser\Advertisement;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use DatabaseMigrations;
use Illuminate\Support\Facades\DB;
use Tests\Helper\AdvertiserTrait;
use Tests\Helper\AdvertiserLoginTrait;
use Tests\Helper\TemplateTrait;
use Tests\Helper\CategoryTrait;
use Tests\Helper\AdvertisementTrait;
use App\Models\Advertisement\Advertisement;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class CreateAdvertisementTest extends TestCase
{
    use RefreshDatabase;
    use AdvertiserLoginTrait;
    use AdvertiserTrait;
    use TemplateTrait;
    use AdvertisementTrait;
    use CategoryTrait;


    public function setup(): void {
        parent::setup();
        $this->insertNecessaryTestData();
    }

    public function insertNecessaryTestData() {
        AdvertiserTrait::insertDefaultAdvertiserData(1);
        CategoryTrait::insertDefaultCategoryData(1);
        TemplateTrait::insertDefaultTemplateData(1, 1);
    }

    public function runApi($requestBody, $expectedResponse, $statusCode = 200) {
        AdvertiserLoginTrait::advertiserLogin($advertiserId = 1, $advertiserStoreAccount = 'store1');
        $response = $this->post("/api/advertiser-advertise", $requestBody);

        $response->assertStatus($statusCode);
        $decodedResponse = $response->decodeResponseJson();

        if ($statusCode == 200) {
            foreach ($expectedResponse as $key => $value) {
                $this->assertEquals($value, $decodedResponse[$key]);
            }
        } else {
            $response->assertJsonFragment($expectedResponse);
        }

        session()->flush();
    }

    /**
     * Summary of test_正常
     * @return void
     */
    public function test_正常()
    {
        $advertiserId = 1;
        $categoryId = 1;
        $templateId = 1;
        $name = "広告1";
        $price = 50;

        $requestBody = [
            'categoryId' => $categoryId,
            'templateId' => $templateId,
            'name' => $name,
            'price' => $price,
        ];

        $expectedResponse = [
            'advertiserId' => $advertiserId,
            'categoryId' => $categoryId,
            'templateId' => $templateId,
            'name' => $name,
            'price' => $price,
            'isStopped' => Advertisement::NO_STOPPED,
            'reviewFlag' => Advertisement::REVIEW_BEFORE,
        ];

        $this->runApi($requestBody, $expectedResponse);
    }
    public function test_categoryIdなし()
    {
        $advertiserId = 1;
        $categoryId = '';
        $templateId = 1;
        $name = "広告1";
        $price = 50;

        $requestBody = [
            'categoryId' => $categoryId,
            'templateId' => $templateId,
            'name' => $name,
            'price' => $price,
        ];

        $expectedResponse = [
            'message' => 'カテゴリは必須項目です。'
        ];

        $this->runApi($requestBody, $expectedResponse, 400);
    }
    public function test_templateIdなし()
    {
        $advertiserId = 1;
        $categoryId = 1;
        $templateId = '';
        $name = "広告1";
        $price = 50;

        $requestBody = [
            'categoryId' => $categoryId,
            'templateId' => $templateId,
            'name' => $name,
            'price' => $price,
        ];

        $expectedResponse = [
            'message' => 'テンプレートIDは必須項目です。'
        ];

        $this->runApi($requestBody, $expectedResponse, 400);
    }
    public function test_nameなし()
    {
        $advertiserId = 1;
        $categoryId = 1;
        $templateId = 1;
        $name = "";
        $price = 50;

        $requestBody = [
            'categoryId' => $categoryId,
            'templateId' => $templateId,
            'name' => $name,
            'price' => $price,
        ];

        $expectedResponse = [
            'message' => '広告名は必須項目です。'
        ];

        $this->runApi($requestBody, $expectedResponse, 400);
    }
    public function test_priceなし()
    {
        $advertiserId = 1;
        $categoryId = 1;
        $templateId = 1;
        $name = "広告1";
        $price = '';

        $requestBody = [
            'categoryId' => $categoryId,
            'templateId' => $templateId,
            'name' => $name,
            'price' => $price,
        ];

        $expectedResponse = [
            'message' => '価格は必須項目です。'
        ];

        $this->runApi($requestBody, $expectedResponse, 400);
    }
    public function test_カテゴリ情報がない()
    {
        $advertiserId = 1;
        $categoryId = 2;
        $templateId = 1;
        $name = "広告1";
        $price = 50;

        $requestBody = [
            'categoryId' => $categoryId,
            'templateId' => $templateId,
            'name' => $name,
            'price' => $price,
        ];

        $expectedResponse = [
            'message' => '対象のカテゴリは存在しません。'
        ];

        $this->runApi($requestBody, $expectedResponse, 404);
    }
    public function test_テンプレート情報がない()
    {
        $advertiserId = 1;
        $categoryId = 1;
        $templateId = 2;
        $name = "広告1";
        $price = 50;

        $requestBody = [
            'categoryId' => $categoryId,
            'templateId' => $templateId,
            'name' => $name,
            'price' => $price,
        ];

        $expectedResponse = [
            'message' => '対象のテンプレートは存在しません。'
        ];

        $this->runApi($requestBody, $expectedResponse, 404);
    }
    public function test_フロアプライス未満()
    {
        $advertiserId = 1;
        $categoryId = 1;
        $templateId = 1;
        $name = "広告1";
        $price = 24;

        $requestBody = [
            'categoryId' => $categoryId,
            'templateId' => $templateId,
            'name' => $name,
            'price' => $price,
        ];

        $expectedResponse = [
            'message' => '最低価格は25円です。'
        ];

        $this->runApi($requestBody, $expectedResponse, 400);
    }
    public function test_1000円以上()
    {
        $advertiserId = 1;
        $categoryId = 1;
        $templateId = 1;
        $name = "広告1";
        $price = 1001;

        $requestBody = [
            'categoryId' => $categoryId,
            'templateId' => $templateId,
            'name' => $name,
            'price' => $price,
        ];

        $expectedResponse = [
            'message' => '最高価格は1000円です。'
        ];

        $this->runApi($requestBody, $expectedResponse, 400);
    }

}
