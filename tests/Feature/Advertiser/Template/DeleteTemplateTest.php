<?php

namespace Tests\Feature\Advertiser\Template;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use DatabaseMigrations;
use Illuminate\Support\Facades\DB;
use Tests\Helper\AdvertiserTrait;
use Tests\Helper\TemplateTrait;
use Tests\Helper\AdvertiserLoginTrait;
use App\Models\Template\Template;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class DeleteTemplateTest extends TestCase
{
    use RefreshDatabase;
    use AdvertiserLoginTrait;
    use AdvertiserTrait;
    use TemplateTrait;

    public function setup(): void
    {
        parent::setup();
        $this->insertNecessaryTestData();
    }

    public function insertNecessaryTestData()
    {
        AdvertiserTrait::insertDefaultAdvertiserData(1);
        AdvertiserTrait::insertDefaultAdvertiserData(2);
        TemplateTrait::insertDefaultTemplateData(1,1);
    }

    public function runApi($templateId, $expectedResponse, $statusCode = 200) {
        AdvertiserLoginTrait::advertiserLogin($advertiserId = 1, $advertiserStoreAccount = 'store1');
        $response = $this->delete("/api/advertiser-template/$templateId",);

        $response->assertStatus($statusCode);
        $response->assertJsonFragment($expectedResponse);

        if ($statusCode != 200) {
            $templateCount = DB::table('templates')->where('id', $templateId)->count();
            $this->assertEquals(0, $templateCount);
        }

        session()->flush();
    }

    /**
     * Summary of test_正常
     * @return void
     */
    public function test_正常()
    {
        $templateId = 1;

        $expectedResponse = TemplateTrait::createExpectedTemplateResponse(1,1);

        $this->runApi($templateId, $expectedResponse);
    }

    public function test_テンプレートIDなし()
    {
        $templateId = '';

        $expectedResponse = [
            'message' => 'テンプレートIDは必須項目です。',
        ];

        $this->runApi($templateId, $expectedResponse, 405);
    }

    public function test_テンプレートIDに紐づくテンプレート情報なし()
    {
        $templateId = 2;

        $expectedResponse = [
            'message' => '対象のテンプレートは存在しません。',
        ];
        $this->runApi($templateId, $expectedResponse, 404);
    }
}