<?php

namespace App\Http\Controllers\Api\Advertiser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AdvertisementService;
use Illuminate\Support\Facades\DB;
use \Symfony\Component\HttpFoundation\Response;

class AdvertisementController extends Controller
{
    /**
     * Summary of __construct
     * @param AdvertisementService $advertisementService
     */
    private $advertisementService;
    public function __construct(AdvertisementService $advertisementService) {
        $this->advertisementService = $advertisementService;
    }

    public function create(Request $request) {
        $advertiserId = $request->advertiserId;
        $requestBody = $request->input();

        $categoryId = isset($requestBody["categoryId"]) ? $requestBody["categoryId"] : null;
        $templateId = isset($requestBody["templateId"]) ? $requestBody["templateId"] : null;
        $name = isset($requestBody["name"]) ? $requestBody["name"] : null;
        $price = isset($requestBody["price"]) ? $requestBody["price"] : null;

        $advertisementId = $this->advertisementService->create($advertiserId, $categoryId, $templateId, $name, $price);
        $advertisement = $this->advertisementService->getByIdForAdvertiser($advertiserId, $advertisementId);
        return json_encode($advertisement);
    }

    public function getByAdvertiserid(Request $request) {
        $advertiserId = $request->advertiserId;

        $advertisements = $this->advertisementService->getByAdvertiserId($advertiserId);
        return json_encode($advertisements);
    }
}