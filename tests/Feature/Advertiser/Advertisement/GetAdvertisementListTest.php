<?php

namespace Tests\Feature\Advertiser\Advertisement;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use DatabaseMigrations;
use Illuminate\Support\Facades\DB;
use Tests\Helper\AdvertiserTrait;
use Tests\Helper\TemplateTrait;
use Tests\Helper\CategoryTrait;
use Tests\Helper\AdvertisementTrait;
use Tests\Helper\AdvertiserLoginTrait;
use App\Models\Template\Template;
use App\Models\Advertisement\Advertisement;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class GetAdvertisementListTest extends TestCase
{
    use RefreshDatabase;
    use AdvertiserLoginTrait;
    use AdvertiserTrait;
    use TemplateTrait;
    use AdvertisementTrait;
    use CategoryTrait;

    public function setup(): void
    {
        parent::setup();
        $this->insertNecessaryTestData();
    }

    public function insertNecessaryTestData()
    {
        AdvertiserTrait::insertDefaultAdvertiserData(1);
        AdvertiserTrait::insertDefaultAdvertiserData(2);
        AdvertiserTrait::insertDefaultAdvertiserData(3);
        CategoryTrait::insertDefaultCategoryData(1);
        TemplateTrait::insertDefaultTemplateData(1,1);
        TemplateTrait::insertDefaultTemplateData(2,1);
        TemplateTrait::insertDefaultTemplateData(3,2);
        AdvertisementTrait::insertDefaultAdvertisementData($num = 1, $advertiserId = 1, $categoryId = 1, $templateId = 1);
        AdvertisementTrait::insertDefaultAdvertisementData($num = 2, $advertiserId = 1, $categoryId = 1, $templateId = 2);
        AdvertisementTrait::insertDefaultAdvertisementData($num = 3, $advertiserId = 2, $categoryId = 1, $templateId = 3);
    }
    /**
     * Summary of test_正常
     * @return void
     */
    public function test_正常()
    {
        $expectedResponse[1] = AdvertisementTrait::createExpectedAdvertisementResponse($num = 1, $advertiserId = 1, $categoryId = 1, $templateId = 1);
        $expectedResponse[2] = AdvertisementTrait::createExpectedAdvertisementResponse($num = 2, $advertiserId = 1, $categoryId = 1, $templateId = 2);

        AdvertiserLoginTrait::advertiserLogin($advertiserId = 1, $advertiserStoreAccount = 'store1');
        $response = $this->get("/api/advertiser-advertise-list");

        $response->assertStatus(200);
        $response->assertJsonFragment($expectedResponse);

        session()->flush();
    }

    public function test_取得なし()
    {
        $expectedResponse = [];

        AdvertiserLoginTrait::advertiserLogin($advertiserId = 3, $advertiserStoreAccount = 'store3');
        $response = $this->get("/api/advertiser-advertise-list");

        $response->assertStatus(200);
        $response->assertJsonFragment($expectedResponse);

        session()->flush();
    }
}