<?php
namespace App\Services;
use Illuminate\Support\Facades\DB;
use App\Repositories\CategoryRepository;
use App\Validation\CategoryValidation;
use App\Interfaces\CategoryRepositoryInterface;
use App\Models\Category\Category;
use \Symfony\Component\HttpFoundation\Response;

class CategoryService {
    /**
     * Summary of __construct
     * @param CategoryRepository $categoryRepository
     */
    private $categoryRepository;

    /**
     * Summary of categoryValidation
     * @var CategoryValidation $categoryValidation
     */
    private $categoryValidation;

    public function __construct(CategoryRepository $categoryRepository, CategoryValidation $categoryValidation) {
        $this->categoryRepository = $categoryRepository;
        $this->categoryValidation = $categoryValidation;
    }

    /**
     * Summary of getFirstLevelCategories
     * @return array<array>
     */
    public function getFirstLevelCategories() {
        $firstLevelCategories = $this->categoryRepository->getFirstLevelCatgories();
        $firstLevelCategoryList = [];
        foreach ($firstLevelCategories as $firstLevelCategory) {
            $firstLevelCategoryList[$firstLevelCategory->getid()] = $this->createResponse($firstLevelCategory);
        }
        return $firstLevelCategoryList;
    }

    public function getAllCategories() {
        $allCategories = $this->categoryRepository->getAllCategories();
        $allCategoryList = [];
        foreach ($allCategories as $category) {
            if ($category->isLevel1()) {
                $allCategoryList['level1'][$category->getid()] = $this->createResponse($category);
            } else if ($category->isLevel2()) {
                $allCategoryList['level2'][$category->getid()] = $this->createResponse($category);
            } else if ($category->isLevel3()) {
                $allCategoryList['level3'][$category->getid()] = $this->createResponse($category);
            }
            
        }
        return $allCategoryList;
    }

    public function getById($categoryId) {
        if (empty($categoryId)){abort(response()->json(['message' => 'カテゴリは必須項目です。'], Response::HTTP_BAD_REQUEST));}

        $category = $this->categoryRepository->getById($categoryId);
        $this->categoryValidation->isExistCategory($categoryId);

        return $category;
    }

    private function createResponse(Category $category) {
        $categoryList = [];
        $categoryList['id'] = $category->getId();
        $categoryList['name'] = $category->getName();
        $categoryList['level'] = $category->getLevel();
        $categoryList['parentId'] = $category->getParentId();
        $categoryList['floorPrice'] = $category->getFloorPrice();
        $categoryList['averageBidPrice'] = $category->getAverageBidPrice();
        $categoryList['isDelete'] = $category->getIsDelete();

        return $categoryList;
    }
}