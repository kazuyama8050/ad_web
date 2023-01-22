<?php
namespace App\Services;
use Illuminate\Support\Facades\DB;
use App\Repositories\CategoryRepository;
use App\Interfaces\CategoryRepositoryInterface;
use App\Models\Category\Category;

class CategoryService {
    /**
     * Summary of __construct
     * @param CategoryRepository $categoryRepository
     */
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository) {
        $this->categoryRepository = $categoryRepository;
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