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

    public function create($delivelerId, $url, $bannerImage, $bannerText) {
        if (empty($url)){abort(response()->json(['message' => '遷移先URLは必須項目です。'], Response::HTTP_BAD_REQUEST));}
        if (empty($bannerImage)){abort(response()->json(['message' => 'バナー画像は必須項目です。'], Response::HTTP_BAD_REQUEST));}
        if (empty($bannerText)){abort(response()->json(['message' => 'バナーテキストは必須項目です。'], Response::HTTP_BAD_REQUEST));}

        $this->templateValidation->validateurl($url);
        $this->templateValidation->validateBannerText($bannerText);
        $this->templateValidation->validateBannerImageSize($bannerImage);
        $this->templateValidation->validateBannerImageMime($bannerImage);

        $mimeType = $bannerImage->extension();
        $timestamp = time();

        $uploadFileName = "${delivelerId}-${timestamp}.${mimeType}";

        try {
            $imagePath = $bannerImage->storeAs("public/uploads/advertisement/${delivelerId}", $uploadFileName);
            $imagePath = $this->changeViewFilePath($imagePath);

            $templateId = $this->templateRepository->create($url, $imagePath, $bannerText);
            $template = $this->templateRepository->getById($templateId);

            $templateResponse = $this->createResponse($template);
            return $templateResponse;

        } catch (\Throwable $e) {
            DB::rollBack();
        }
        
    }

    private function changeViewFilePath($imagePath) {
        return str_replace("public", "storage", $imagePath);
    }

    private function createResponse(Template $template) {
        $templateList = [];
        $templateList['id'] = $template->getId();
        $templateList['url'] = $template->getUrl();
        $templateList['bannerText'] = $template->getText();
        $templateList['imagePath'] = $template->getImagePath();

        return $templateList;
    }
}