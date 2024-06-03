<?php

namespace App\Http\Controllers\Api\Advertiser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AdvertiserService;
use Illuminate\Support\Facades\Route;

class LoginAdvertiserController extends Controller
{
    /**
     * Summary of __construct
     * @param AdvertiserService $advertiserService
     */
    private $advertiserService;
    public function __construct(AdvertiserService $advertiserService) {
        $this->advertiserService = $advertiserService;
    }

    public function login(Request $request) {
        $requestBody = $request->input();
        $storeAccount = isset($requestBody["storeAccount"]) ? $requestBody["storeAccount"] : null;
        $password = isset($requestBody["password"]) ? $requestBody["password"] : null;

        $advertiser = $this->advertiserService->login(
            $storeAccount,
            $password,
        );

        $request->session()->put('advertiserStoreAccount', $advertiser->getStoreAccount());
        $request->session()->put('advertiserId', $advertiser->getId());

        return json_encode(['message' => 'OK']);

    }

    public function loginCheck() {
        $this->advertiserService->loginCheck();
        return json_encode(['message' => 'OK']);
    }
}