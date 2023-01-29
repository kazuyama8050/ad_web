<?php
namespace App\Services;
use Illuminate\Support\Facades\DB;
use App\Repositories\TemplateRepository;
use App\Interfaces\TemplateRepositoryInterface;
use App\Validation\TemplateValidation;
use App\Models\Template\Template;
use \Symfony\Component\HttpFoundation\Response;

class TemplateService {
    /**
     * Summary of __construct
     * @param TemplateRepository $templateRepository
     */
    private $templateRepository;

    /**
     * Summary of templateValidation
     * @param TemplateValidation $templateValidation
     */
    private $templateValidation;

    public function __construct(TemplateRepository $templateRepository, TemplateValidation $templateValidation) {
        $this->templateRepository = $templateRepository;
        $this->templateValidation = $templateValidation;
    }

    public function create($advertiserId, $url, $bannerImage, $bannerText) {
        if (empty($url)){abort(response()->json(['message' => '遷移先URLは必須項目です。'], Response::HTTP_BAD_REQUEST));}
        if (empty($bannerImage)){abort(response()->json(['message' => 'バナー画像は必須項目です。'], Response::HTTP_BAD_REQUEST));}
        if (empty($bannerText)){abort(response()->json(['message' => 'バナーテキストは必須項目です。'], Response::HTTP_BAD_REQUEST));}

        $this->templateValidation->validateurl($url);
        $this->templateValidation->validateBannerText($bannerText);
        $this->templateValidation->validateBannerImageSize($bannerImage);
        $this->templateValidation->validateBannerImageMime($bannerImage);

        $mimeType = $bannerImage->extension();
        $timestamp = time();

        $uploadFileName = "${advertiserId}-${timestamp}.${mimeType}";

        try {
            $imagePath = $bannerImage->storeAs("public/uploads/advertisement/${advertiserId}", $uploadFileName);
            $imagePath = $this->changeViewFilePath($imagePath);
            $templateId = $this->templateRepository->create($advertiserId, $url, $imagePath, $bannerText);
            $template = $this->templateRepository->getById($advertiserId, $templateId);

            $templateResponse = $this->createResponse($template);
            return $templateResponse;

        } catch (\Throwable $e) {
            DB::rollBack();
            abort(response()->json(['message' => '予期せぬエラーが発生しました。'], Response::HTTP_INTERNAL_SERVER_ERROR));
        }
        
    }

    public function getByAdvertiserId($advertiserId) {
        $templates = $this->templateRepository->getByAdvertiserId($advertiserId);

        if (empty($templates)) {
            return [];
        }

        $templateList = [];
        foreach ($templates as $template) {
            $templateList[$template->getId()] = $this->createResponse($template);
        }

        return $templateList;
    }

    public function getById($advertiserId, $templateId, $ret = true) {
        if (empty($templateId)){abort(response()->json(['message' => 'テンプレートIDは必須項目です。'], Response::HTTP_BAD_REQUEST));}
        $template = $this->templateRepository->getById($advertiserId, $templateId);

        $this->templateValidation->isExistTemplate($template);

        if ($ret) {return $this->createResponse($template);}

        return $template;
    }

    public function deleteByTemplateId($advertiserId, $templateId) {
        if (empty($templateId)){abort(response()->json(['message' => 'テンプレートIDは必須項目です。'], Response::HTTP_BAD_REQUEST));}

        $template = $this->templateRepository->getById($advertiserId, $templateId);
        $this->templateValidation->isExistTemplate($template);
        try {
            $this->templateRepository->deleteByTemplateId($templateId);
            return $this->createResponse($template);

        } catch (\Throwable $e) {
            DB::rollBack();
            abort(response()->json(['message' => '予期せぬエラーが発生しました。'], Response::HTTP_INTERNAL_SERVER_ERROR));
        }
    } 

    private function changeViewFilePath($imagePath) {
        return str_replace("public", "storage", $imagePath);
    }

    private function createResponse(Template $template) {
        $templateList = [];
        $templateList['id'] = $template->getId();
        $templateList['advertiserId'] = $template->getAdvertiserId();
        $templateList['url'] = $template->getUrl();
        $templateList['bannerText'] = $template->getText();
        $templateList['imagePath'] = $template->getImagePath();

        return $templateList;
    }
}