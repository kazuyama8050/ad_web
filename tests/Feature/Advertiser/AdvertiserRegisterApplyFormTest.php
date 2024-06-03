<?php

namespace Tests\Feature\Advertiser;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use DatabaseMigrations;
use Illuminate\Support\Facades\DB;
use Tests\Helper\AdvertiserTrait;

class AdvertiserRegisterApplyFormTest extends TestCase
{
    use AdvertiserTrait;
    use RefreshDatabase;
    public function setup(): void {
        parent::setup();
        $this->insertNecessaryData();
    }

    public function insertNecessaryData() {
        AdvertiserTrait::insertDefaultAdvertiserData(1);
        AdvertiserTrait::insertDefaultAdvertiserData(2);
    }

    public function runApi($requestBody, $advertiserStoreAccount, $expectedResponse = null, $statusCode = 200) {
        $response = $this->post('/api/register-advertiser-form', $requestBody);

        $response->assertStatus($statusCode);
        if ($statusCode == 200) {
            $decodedResponse = $response->decodeResponseJson();
            $advertiserId = $decodedResponse['advertiserId'];
            $sessionAdvertiserStoreAccount = session()->get('advertiserStoreAccount');
            $sessionAdvertiserId = session()->get('advertiserId');

            $this->assertEquals($advertiserId, $sessionAdvertiserId);
            $this->assertEquals($advertiserStoreAccount, $sessionAdvertiserStoreAccount);
            session()->flush();
        } else {
            $response->assertJsonFragment($expectedResponse);
        }
    }

    /**
     * Summary of test_正常
     * @return void
     */
    public function test_正常()
    {
        $advertiserStoreAccount = 'store';

        $requestBody = [
            'storeAccount' => $advertiserStoreAccount,
            'companyName' => "companyname",
            'companyZipcode' => "000-0000",
            'companyAddress' => "companyAddress",
            'companySiteUrl' => "https://site_url",
            'managerLastName' => "lastName",
            'managerFirstName' => "firstName",
            'managerPhone' => "080-0808-0800",
            'managerEmail' => "advertiser@email.com",
        ];
        
        $this->runApi($requestBody, $advertiserStoreAccount);
    }
    public function test_ストアアカウントなし()
    {
        $advertiserStoreAccount = '';

        $requestBody = [
            'storeAccount' => $advertiserStoreAccount,
            'companyName' => "companyname",
            'companyZipcode' => "000-0000",
            'companyAddress' => "companyAddress",
            'companySiteUrl' => "https://site_url",
            'managerLastName' => "lastName",
            'managerFirstName' => "firstName",
            'managerPhone' => "080-0808-0800",
            'managerEmail' => "advertiser@email.com",
        ];

        $expectedResponse = [
            'message' => 'ストアアカウントは必須です。',
        ];
        
        $this->runApi($requestBody, $advertiserStoreAccount, $expectedResponse, 404);
    }
    public function test_会社名なし()
    {
        $advertiserStoreAccount = 'store';

        $requestBody = [
            'storeAccount' => $advertiserStoreAccount,
            'companyName' => "",
            'companyZipcode' => "000-0000",
            'companyAddress' => "companyAddress",
            'companySiteUrl' => "https://site_url",
            'managerLastName' => "lastName",
            'managerFirstName' => "firstName",
            'managerPhone' => "080-0808-0800",
            'managerEmail' => "advertiser@email.com",
        ];

        $expectedResponse = [
            'message' => '会社名は必須です。',
        ];
        
        $this->runApi($requestBody, $advertiserStoreAccount, $expectedResponse, 404);
    }
    public function test_会社郵便番号なし()
    {
        $advertiserStoreAccount = 'store';

        $requestBody = [
            'storeAccount' => $advertiserStoreAccount,
            'companyName' => "companyname",
            'companyZipcode' => "",
            'companyAddress' => "companyAddress",
            'companySiteUrl' => "https://site_url",
            'managerLastName' => "lastName",
            'managerFirstName' => "firstName",
            'managerPhone' => "080-0808-0800",
            'managerEmail' => "advertiser@email.com",
        ];

        $expectedResponse = [
            'message' => '会社郵便番号は必須です。',
        ];
        
        $this->runApi($requestBody, $advertiserStoreAccount, $expectedResponse, 404);
    }
    public function test_会社住所なし()
    {
        $advertiserStoreAccount = 'store';

        $requestBody = [
            'storeAccount' => $advertiserStoreAccount,
            'companyName' => "companyname",
            'companyZipcode' => "000-0000",
            'companyAddress' => "",
            'companySiteUrl' => "https://site_url",
            'managerLastName' => "lastName",
            'managerFirstName' => "firstName",
            'managerPhone' => "080-0808-0800",
            'managerEmail' => "advertiser@email.com",
        ];

        $expectedResponse = [
            'message' => '会社住所は必須です。',
        ];
        
        $this->runApi($requestBody, $advertiserStoreAccount, $expectedResponse, 404);
    }
    public function test_会社サイトURLなし()
    {
        $advertiserStoreAccount = 'store';

        $requestBody = [
            'storeAccount' => $advertiserStoreAccount,
            'companyName' => "companyname",
            'companyZipcode' => "000-0000",
            'companyAddress' => "companyAddress",
            'companySiteUrl' => "",
            'managerLastName' => "lastName",
            'managerFirstName' => "firstName",
            'managerPhone' => "080-0808-0800",
            'managerEmail' => "advertiser@email.com",
        ];

        $expectedResponse = [
            'message' => '会社サイトURLは必須です。',
        ];
        
        $this->runApi($requestBody, $advertiserStoreAccount, $expectedResponse, 404);
    }
    public function test_担当者苗字なし()
    {
        $advertiserStoreAccount = 'store';

        $requestBody = [
            'storeAccount' => $advertiserStoreAccount,
            'companyName' => "companyname",
            'companyZipcode' => "000-0000",
            'companyAddress' => "companyAddress",
            'companySiteUrl' => "https://site_url",
            'managerLastName' => "",
            'managerFirstName' => "firstName",
            'managerPhone' => "080-0808-0800",
            'managerEmail' => "advertiser@email.com",
        ];

        $expectedResponse = [
            'message' => '担当者苗字は必須です。',
        ];
        
        $this->runApi($requestBody, $advertiserStoreAccount, $expectedResponse, 404);
    }
    public function test_担当者名前なし()
    {
        $advertiserStoreAccount = 'store';

        $requestBody = [
            'storeAccount' => $advertiserStoreAccount,
            'companyName' => "companyname",
            'companyZipcode' => "000-0000",
            'companyAddress' => "companyAddress",
            'companySiteUrl' => "https://site_url",
            'managerLastName' => "lastName",
            'managerFirstName' => "",
            'managerPhone' => "080-0808-0800",
            'managerEmail' => "advertiser@email.com",
        ];

        $expectedResponse = [
            'message' => '担当者名前は必須です。',
        ];
        
        $this->runApi($requestBody, $advertiserStoreAccount, $expectedResponse, 404);
    }
    public function test_担当者電話番号なし()
    {
        $advertiserStoreAccount = 'store';

        $requestBody = [
            'storeAccount' => $advertiserStoreAccount,
            'companyName' => "companyname",
            'companyZipcode' => "000-0000",
            'companyAddress' => "companyAddress",
            'companySiteUrl' => "https://site_url",
            'managerLastName' => "lastName",
            'managerFirstName' => "firstName",
            'managerPhone' => "",
            'managerEmail' => "advertiser@email.com",
        ];

        $expectedResponse = [
            'message' => '担当者電話番号は必須です。',
        ];
        
        $this->runApi($requestBody, $advertiserStoreAccount, $expectedResponse, 404);
    }
    public function test_担当者メールアドレスなし()
    {
        $advertiserStoreAccount = 'store';

        $requestBody = [
            'storeAccount' => $advertiserStoreAccount,
            'companyName' => "companyname",
            'companyZipcode' => "000-0000",
            'companyAddress' => "companyAddress",
            'companySiteUrl' => "https://site_url",
            'managerLastName' => "lastName",
            'managerFirstName' => "firstName",
            'managerPhone' => "080-0808-0800",
            'managerEmail' => "",
        ];

        $expectedResponse = [
            'message' => '担当者メールアドレスは必須です。',
        ];
        
        $this->runApi($requestBody, $advertiserStoreAccount, $expectedResponse, 404);
    }

    public function test_ストアアカウント11文字以上()
    {
        $advertiserStoreAccount = 'storeAccount';

        $requestBody = [
            'storeAccount' => $advertiserStoreAccount,
            'companyName' => "companyname",
            'companyZipcode' => "000-0000",
            'companyAddress' => "companyAddress",
            'companySiteUrl' => "https://site_url",
            'managerLastName' => "lastName",
            'managerFirstName' => "firstName",
            'managerPhone' => "080-0808-0800",
            'managerEmail' => "advertiser@email.com",
        ];

        $expectedResponse = [
            'message' => 'ストアアカウントは10文字以内で入力してください。',
        ];
        
        $this->runApi($requestBody, $advertiserStoreAccount, $expectedResponse, 400);
    }

    public function test_郵便番号が不正()
    {
        $advertiserStoreAccount = 'store';

        $requestBody = [
            'storeAccount' => $advertiserStoreAccount,
            'companyName' => "companyname",
            'companyZipcode' => "000-00001",
            'companyAddress' => "companyAddress",
            'companySiteUrl' => "https://site_url",
            'managerLastName' => "lastName",
            'managerFirstName' => "firstName",
            'managerPhone' => "080-0808-0800",
            'managerEmail' => "advertiser@email.com",
        ];

        $expectedResponse = [
            'message' => '不正な郵便番号の形式です。',
        ];
        
        $this->runApi($requestBody, $advertiserStoreAccount, $expectedResponse, 400);
    }

    public function test_担当者苗字が31文字以上()
    {
        $advertiserStoreAccount = 'store';

        $requestBody = [
            'storeAccount' => $advertiserStoreAccount,
            'companyName' => "companyname",
            'companyZipcode' => "000-0000",
            'companyAddress' => "companyAddress",
            'companySiteUrl' => "https://site_url",
            'managerLastName' => "lastNameaaaaaaaaaaaaaaaaaaaasadasfarbbsrhdttydnnjfyh",
            'managerFirstName' => "firstName",
            'managerPhone' => "080-0808-0800",
            'managerEmail' => "advertiser@email.com",
        ];

        $expectedResponse = [
            'message' => '名前は30文字以内で入力してください。',
        ];
        
        $this->runApi($requestBody, $advertiserStoreAccount, $expectedResponse, 400);
    }

    public function test_担当者名前は30文字以内で入力してください。()
    {
        $advertiserStoreAccount = 'store';

        $requestBody = [
            'storeAccount' => $advertiserStoreAccount,
            'companyName' => "companyname",
            'companyZipcode' => "000-0000",
            'companyAddress' => "companyAddress",
            'companySiteUrl' => "https://site_url",
            'managerLastName' => "lastName",
            'managerFirstName' => "firstNameagkdjgiffsavifdvdszighspgds@gfsghdpgsipergusepir",
            'managerPhone' => "080-0808-0800",
            'managerEmail' => "advertiser@email.com",
        ];

        $expectedResponse = [
            'message' => '名前は30文字以内で入力してください。',
        ];
        
        $this->runApi($requestBody, $advertiserStoreAccount, $expectedResponse, 400);
    }

    public function test_電話番号が不正()
    {
        $advertiserStoreAccount = 'store';

        $requestBody = [
            'storeAccount' => $advertiserStoreAccount,
            'companyName' => "companyname",
            'companyZipcode' => "000-0000",
            'companyAddress' => "companyAddress",
            'companySiteUrl' => "https://site_url",
            'managerLastName' => "lastName",
            'managerFirstName' => "firstName",
            'managerPhone' => "080-0808-0800a",
            'managerEmail' => "advertiser@email.com",
        ];

        $expectedResponse = [
            'message' => '不正な電話番号の形式です。',
        ];
        
        $this->runApi($requestBody, $advertiserStoreAccount, $expectedResponse, 400);
    }

    public function test_メールアドレスが不正()
    {
        $advertiserStoreAccount = 'store';

        $requestBody = [
            'storeAccount' => $advertiserStoreAccount,
            'companyName' => "companyname",
            'companyZipcode' => "000-0000",
            'companyAddress' => "companyAddress",
            'companySiteUrl' => "https://site_url",
            'managerLastName' => "lastName",
            'managerFirstName' => "firstName",
            'managerPhone' => "080-0808-0800",
            'managerEmail' => "advertiseremail.com",
        ];

        $expectedResponse = [
            'message' => '不正なメールアドレスの形式です。',
        ];
        
        $this->runApi($requestBody, $advertiserStoreAccount, $expectedResponse, 400);
    }

    public function test_登録済みアカウント()
    {
        $advertiserStoreAccount = 'store1';

        $requestBody = [
            'storeAccount' => $advertiserStoreAccount,
            'companyName' => "companyname",
            'companyZipcode' => "000-0000",
            'companyAddress' => "companyAddress",
            'companySiteUrl' => "https://site_url",
            'managerLastName' => "lastName",
            'managerFirstName' => "firstName",
            'managerPhone' => "080-0808-0800",
            'managerEmail' => "advertiser@email.com",
        ];

        $expectedResponse = [
            'message' => '登録済みのストアアカウントです。',
        ];
        
        $this->runApi($requestBody, $advertiserStoreAccount, $expectedResponse, 400);
    }

    public function test_登録済みメールアドレス()
    {
        $advertiserStoreAccount = 'store';

        $requestBody = [
            'storeAccount' => $advertiserStoreAccount,
            'companyName' => "companyname",
            'companyZipcode' => "000-0000",
            'companyAddress' => "companyAddress",
            'companySiteUrl' => "https://site_url",
            'managerLastName' => "lastName",
            'managerFirstName' => "firstName",
            'managerPhone' => "080-0808-0800",
            'managerEmail' => "advertiser1@email.com",
        ];

        $expectedResponse = [
            'message' => '登録済みのメールアドレスです。',
        ];
        
        $this->runApi($requestBody, $advertiserStoreAccount, $expectedResponse, 400);
    }
}
