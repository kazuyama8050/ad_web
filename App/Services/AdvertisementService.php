<?php
namespace App\Services;
use Illuminate\Support\Facades\DB;
use App\Repositories\AdvertisementRepository;
use App\Interfaces\AdvertisementRepositoryInterface;
use App\Validation\AdvertisementValidation;
use App\Models\Advertisement\Advertisement;
use \Symfony\Component\HttpFoundation\Response;
use App\Services\CategoryService;
use App\Services\TemplateService;
use App\Validation\CategoryValidation;
use App\Validation\TemplateValidation;

class AdvertisementService {
    /**
     * Summary of advertisementRepository
     * @param AdvertisementRepository $advertisementRepository
     */
    private $advertisementRepository;

    /**
     * Summary of advertisementValidation
     * @param AdvertisementValidation $advertisementValidation
     */
    private $advertisementValidation;

    /**
     * Summary of categoryService
     * @var CategoryService $categoryService
     */
    private $categoryService;

    /**
     * Summary of templateService
     * @var TemplateService $templateService
     */
    private $templateService;

    /**
     * Summary of categoryValidation
     * @var CategoryValidation $categoryValidation
     */
    private $categoryValidation;

    /**
     * Summary of templateValidation
     * @var TemplateValidation $templateValidation
     */
    private $templateValidation;

    public function __construct(
        AdvertisementRepository $advertisementRepository, 
        AdvertisementValidation $advertisementValidation,
        CategoryService $categoryService,
        TemplateService $templateService,
        CategoryValidation $categoryValidation,
        TemplateValidation $templateValidation
    ) {
        $this->advertisementRepository = $advertisementRepository;
        $this->advertisementValidation = $advertisementValidation;
        $this->categoryService = $categoryService;
        $this->templateService = $templateService;
        $this->categoryValidation = $categoryValidation;
        $this->templateValidation = $templateValidation;
    }

    public function getByIdForAdvertiser($advertiserId, $advertisementId, $ret = true) {
        if (empty($advertisementId)){abort(response()->json(['message' => '広告IDは必須項目です。'], Response::HTTP_BAD_REQUEST));}

        $advertisement = $this->advertisementRepository->getByIdForAdvertiser($advertisementId, $advertiserId);
        $this->advertisementValidation->isExistAdvertisement($advertisement);

        if ($ret) {
            return $this->createResponse($advertisement);
        }
        return $advertisement;
    }

    public function getByAdvertiserId($advertiserId, $ret = true) {
        $advertisements = $this->advertisementRepository->getByAdvertiserId($advertiserId);
        if (empty($advertisements) || $advertisements == null) {
            return [];
        }

        if ($ret) {
            $advertisementList = [];
            foreach ($advertisements as $advertisement) {
                $advertisementList[$advertisement->getId()] = $this->createResponse($advertisement);
            }
            return $advertisementList;
        }

        return $advertisements;
    }

    public function create($advertiserId, $categoryId, $templateId, $name, $price) {
        if (empty($categoryId)){abort(response()->json(['message' => 'カテゴリは必須項目です。'], Response::HTTP_BAD_REQUEST));}
        if (empty($templateId)){abort(response()->json(['message' => 'テンプレートIDは必須項目です。'], Response::HTTP_BAD_REQUEST));}
        if (empty($name)){abort(response()->json(['message' => '広告名は必須項目です。'], Response::HTTP_BAD_REQUEST));}
        if (empty($price)){abort(response()->json(['message' => '価格は必須項目です。'], Response::HTTP_BAD_REQUEST));}

        $category = $this->categoryService->getById($categoryId);
        $this->categoryValidation->isExistCategory($category);
        $this->advertisementValidation->validatePrice($category, $price);

        $template = $this->templateService->getById($advertiserId, $templateId, false);
        $this->templateValidation->isExistTemplate($template);
        try {
            $advertisementId = $this->advertisementRepository->create($advertiserId, $categoryId, $templateId, $name, $price);
            return $advertisementId;

        } catch (\Throwable $e) {
            DB::rollBack();
            abort(response()->json(['message' => '予期せぬエラーが発生しました。'], Response::HTTP_INTERNAL_SERVER_ERROR));
        }
    }

    private function createResponse(Advertisement $advertisement) {
        $advertisementList = [];
        $advertisementList['id'] = $advertisement->getId();
        $advertisementList['advertiserId'] = $advertisement->getAdvertiserId();
        $advertisementList['categoryId'] = $advertisement->getCategoryId();
        $advertisementList['templateId'] = $advertisement->getTemplateId();
        $advertisementList['name'] = $advertisement->getName();
        $advertisementList['price'] = $advertisement->getPrice();
        $advertisementList['isStopped'] = $advertisement->getIsStopped();
        $advertisementList['reviewFlag'] = $advertisement->getReviewFlag();

        return $advertisementList;
    }
}