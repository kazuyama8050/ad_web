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

class GetTemplateListTest extends TestCase
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
        TemplateTrait::insertDefaultTemplateData(2,1);
    }
    /**
     * Summary of test_正常
     * @return void
     */
    public function test_正常()
    {
        $expectedResponse[1] = TemplateTrait::createExpectedTemplateResponse(1,1);
        $expectedResponse[2] = TemplateTrait::createExpectedTemplateResponse(2,1);

        $templates = DB::table('templates')->get();

        AdvertiserLoginTrait::advertiserLogin($advertiserId = 1, $advertiserStoreAccount = 'store1');
        $response = $this->get("/api/advertise-template-list");

        $response->assertStatus(200);
        $response->assertJsonFragment($expectedResponse);

        session()->flush();
    }

    public function test_取得なし()
    {
        $expectedResponse = [];

        AdvertiserLoginTrait::advertiserLogin($advertiserId = 2, $advertiserStoreAccount = 'store2');
        $response = $this->get("/api/advertise-template-list");

        $response->assertStatus(200);
        $response->assertJsonFragment($expectedResponse);

        session()->flush();
    }
}