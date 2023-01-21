<?php

namespace Tests\Feature\User\Template;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use DatabaseMigrations;
use Illuminate\Support\Facades\DB;
use Tests\Helper\UserExaminationTrait;
use Tests\Helper\UserTrait;
use Tests\Helper\UserLoginTrait;
use App\Models\Template\Template;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class CreateTemplateTest extends TestCase
{
    use RefreshDatabase;
    use UserExaminationTrait;
    use UserTrait;
    use UserLoginTrait;

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
        UserLoginTrait::userLogin(1, 'validate1@email.com');
        $response = $this->post("/api/user-template-create", $requestBody);

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
