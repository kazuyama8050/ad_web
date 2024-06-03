<?php

namespace App\Http\Controllers\Api\Advertiser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\TemplateService;

class TemplateController extends Controller
{
    /**
     * Summary of __construct
     * @param TemplateService $templateService
     */
    private $templateService;
    public function __construct(TemplateService $templateService) {
        $this->templateService = $templateService;
    }

    public function create(Request $request) {
        $advertiserId = $request->advertiserId;
        $requestBody = $request->input();

        $url = isset($requestBody["url"]) ? $requestBody["url"] : null;
        $bannerImage = $request->file('bannerImage');
        $bannerImage = isset($bannerImage) ? $bannerImage : null;
        $bannerText = isset($requestBody["bannerText"]) ? $requestBody["bannerText"] : null;
        
        $template = $this->templateService->create($advertiserId, $url, $bannerImage, $bannerText);

        return json_encode($template);

    }

    public function getByAdvertiserId(Request $request) {
        $advertiserId = $request->advertiserId;

        $templateList = $this->templateService->getByAdvertiserId($advertiserId);
        return json_encode($templateList);
    }

    public function getById(Request $request) {
        $advertiserId = $request->advertiserId;
        $templateId = $request->templateId ? $request->templateId : null;

        $template = $this->templateService->getById($advertiserId, $templateId);

        return json_encode($template);
    }

    public function deleteByTemplateId(Request $request) {
        $advertiserId = $request->advertiserId;

        $templateId = $request->templateId ? $request->templateId : null;

        $template = $this->templateService->deleteByTemplateId($advertiserId, $templateId);

        return json_encode($template);
    }
}