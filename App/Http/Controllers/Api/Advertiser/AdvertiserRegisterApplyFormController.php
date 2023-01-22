<?php

namespace App\Http\Controllers\Api\Advertiser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AdvertiserService;
use Illuminate\Support\Facades\Route;

class AdvertiserRegisterApplyFormController extends Controller
{
    /**
     * Summary of __construct
     * @param AdvertiserService $advertiserService
     */
    private $advertiserService;
    public function __construct(AdvertiserService $advertiserService) {
        $this->advertiserService = $advertiserService;
    }

    public function create(Request $request) {
        $requestBody = $request->input();
        $storeAccount = isset($requestBody["storeAccount"]) ? $requestBody["storeAccount"] : null;
        $companyName = isset($requestBody["companyName"]) ? $requestBody["companyName"] : null;
        $companyZipcode = isset($requestBody["companyZipcode"]) ? $requestBody["companyZipcode"] : null;
        $companyAddress = isset($requestBody["companyAddress"]) ? $requestBody["companyAddress"] : null;
        $companySiteUrl = isset($requestBody["companySiteUrl"]) ? $requestBody["companySiteUrl"] : null;
        $managerLastName = isset($requestBody["managerLastName"]) ? $requestBody["managerLastName"] : null;
        $managerFirstName = isset($requestBody["managerFirstName"]) ? $requestBody["managerFirstName"] : null;
        $managerEmail = isset($requestBody["managerEmail"]) ? $requestBody["managerEmail"] : null;
        $managerPhone = isset($requestBody["managerPhone"]) ? $requestBody["managerPhone"] : null;

        $advertiser = $this->advertiserService->createAdvertiser(
            $storeAccount,
            $companyName,
            $companyZipcode,
            $companyAddress,
            $companySiteUrl,
            $managerLastName,
            $managerFirstName,
            $managerPhone,
            $managerEmail,
        );

        $request->session()->put('advertiserStoreAccount', $storeAccount);
        $request->session()->put('advertiserId', $advertiser->getId());

        return json_encode([
            'advertiserId' => $advertiser->getId(),
        ]);

    }

    public function loginCheck() {
        $this->advertiserService->loginCheck();
        return json_encode(['message' => 'OK']);
    }
}