<?php

namespace Tests\Feature\Advertiser\Template;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use DatabaseMigrations;
use Illuminate\Support\Facades\DB;
use Tests\Helper\AdvertiserTrait;
use Tests\Helper\AdvertiserLoginTrait;
use App\Models\Template\Template;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class CreateTemplateTest extends TestCase
{
    use RefreshDatabase;
    use AdvertiserLoginTrait;
    use AdvertiserTrait;

    public function setup(): void {
        parent::setup();
        $this->insertNecessaryTestData();
    }

    public function insertNecessaryTestData() {
        AdvertiserTrait::insertDefaultAdvertiserData(1);
    }

    public function runApi($requestBody, $expectedResponse, $statusCode = 200) {
        AdvertiserLoginTrait::advertiserLogin($advertiserId = 1, $advertiserStoreAccount = 'store1');
        $response = $this->post("/api/advertise-template-create", $requestBody);

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

        Storage::fake('local');
        $file = UploadedFile::fake()->image('test.jpg', Template::IMAGE_HEIGHT, Template::IMAGE_WIDTH);

        $url = "https://test.com";
        $bannerText = "あいうえおかきくけこ";

        $requestBody = [
            'url' => $url,
            'bannerImage' => $file,
            'bannerText' => $bannerText,
        ];

        $expectedResponse = [
            'url' => $url,
            'bannerText' => $bannerText,
        ];

        $this->runApi($requestBody, $expectedResponse);
    }
    public function test_urlなし()
    {

        Storage::fake('local');
        $file = UploadedFile::fake()->image('test.jpg', Template::IMAGE_HEIGHT, Template::IMAGE_WIDTH);

        $url = "";
        $bannerText = "あいうえおかきくけこ";

        $requestBody = [
            'url' => $url,
            'bannerImage' => $file,
            'bannerText' => $bannerText,
        ];

        $expectedResponse = [
            'message' => '遷移先URLは必須項目です。',
        ];

        $this->runApi($requestBody, $expectedResponse, 400);
    }
    public function test_bannerTextなし()
    {

        Storage::fake('local');
        $file = UploadedFile::fake()->image('test.jpg', Template::IMAGE_HEIGHT, Template::IMAGE_WIDTH);

        $url = "https://test.com";
        $bannerText = "";

        $requestBody = [
            'url' => $url,
            'bannerImage' => $file,
            'bannerText' => $bannerText,
        ];

        $expectedResponse = [
            'message' => 'バナーテキストは必須項目です。',
        ];

        $this->runApi($requestBody, $expectedResponse, 400);
    }
    public function test_bannerImageなし()
    {
        $file = '';

        $url = "https://test.com";
        $bannerText = "あいうえおかきくけこ";

        $requestBody = [
            'url' => $url,
            'bannerImage' => $file,
            'bannerText' => $bannerText,
        ];

        $expectedResponse = [
            'message' => 'バナー画像は必須項目です。',
        ];

        $this->runApi($requestBody, $expectedResponse, 400);
    }
    public function test_url不正()
    {
        Storage::fake('local');
        $file = UploadedFile::fake()->image('test.jpg', Template::IMAGE_HEIGHT, Template::IMAGE_WIDTH);

        $url = "htt/test.com";
        $bannerText = "あいうえおかきくけこ";

        $requestBody = [
            'url' => $url,
            'bannerImage' => $file,
            'bannerText' => $bannerText,
        ];

        $expectedResponse = [
            'message' => '不正な遷移先URLの形式です。',
        ];

        $this->runApi($requestBody, $expectedResponse, 400);
    }
    public function test_bannerText_10文字未満()
    {
        Storage::fake('local');
        $file = UploadedFile::fake()->image('test.jpg', Template::IMAGE_HEIGHT, Template::IMAGE_WIDTH);

        $url = "https://test.com";
        $bannerText = "あいうえおかきくけ";

        $requestBody = [
            'url' => $url,
            'bannerImage' => $file,
            'bannerText' => $bannerText,
        ];

        $expectedResponse = [
            'message' => 'バナーテキストは10文字以上50文字以内で入力してください。',
        ];

        $this->runApi($requestBody, $expectedResponse, 400);
    }
    public function test_bannerText_51文字以上()
    {
        Storage::fake('local');
        $file = UploadedFile::fake()->image('test.jpg', Template::IMAGE_HEIGHT, Template::IMAGE_WIDTH);

        $url = "https://test.com";
        $bannerText = "あいうえおかきくけこあいうえおかきくけこあいうえおかきくけこあいうえおかきくけこあいうえおかきくけこあいうえおかきくけこ";

        $requestBody = [
            'url' => $url,
            'bannerImage' => $file,
            'bannerText' => $bannerText,
        ];

        $expectedResponse = [
            'message' => 'バナーテキストは10文字以上50文字以内で入力してください。',
        ];

        $this->runApi($requestBody, $expectedResponse, 400);
    }
    public function test_画像ファイル縦サイズエラー()
    {

        Storage::fake('local');
        $file = UploadedFile::fake()->image('test.jpg', Template::IMAGE_HEIGHT + 1, Template::IMAGE_WIDTH);

        $url = "https://test.com";
        $bannerText = "あいうえおかきくけこ";

        $requestBody = [
            'url' => $url,
            'bannerImage' => $file,
            'bannerText' => $bannerText,
        ];

        $expectedResponse = [
            'message' => 'バナー画像のサイズは30×30で指定してください。',
        ];

        $this->runApi($requestBody, $expectedResponse, 400);
    }
    public function test_画像ファイル横サイズエラー()
    {

        Storage::fake('local');
        $file = UploadedFile::fake()->image('test.jpg', Template::IMAGE_HEIGHT, Template::IMAGE_WIDTH + 1);

        $url = "https://test.com";
        $bannerText = "あいうえおかきくけこ";

        $requestBody = [
            'url' => $url,
            'bannerImage' => $file,
            'bannerText' => $bannerText,
        ];

        $expectedResponse = [
            'message' => 'バナー画像のサイズは30×30で指定してください。',
        ];

        $this->runApi($requestBody, $expectedResponse, 400);
    }
    public function test_画像ファイルmimeタイプ不正エラー()
    {

        Storage::fake('local');
        $file = UploadedFile::fake()->image('test.pdf', Template::IMAGE_HEIGHT, Template::IMAGE_WIDTH);

        $url = "https://test.com";
        $bannerText = "あいうえおかきくけこ";

        $requestBody = [
            'url' => $url,
            'bannerImage' => $file,
            'bannerText' => $bannerText,
        ];

        $expectedResponse = [
            'message' => 'バナー画像はpng、jpgのみアップロード可能です。',
        ];

        $this->runApi($requestBody, $expectedResponse, 400);
    }

}
