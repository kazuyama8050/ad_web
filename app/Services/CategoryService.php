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
            $firstLevelCategoryList[$firstLevelCategory->getId()]['id'] = $firstLevelCategory->getId();
            $firstLevelCategoryList[$firstLevelCategory->getId()]['name'] = $firstLevelCategory->getName();
            $firstLevelCategoryList[$firstLevelCategory->getId()]['level'] = $firstLevelCategory->getLevel();
            $firstLevelCategoryList[$firstLevelCategory->getId()]['parentId'] = $firstLevelCategory->getParentId();
            $firstLevelCategoryList[$firstLevelCategory->getId()]['floorPrice'] = $firstLevelCategory->getFloorPrice();
            $firstLevelCategoryList[$firstLevelCategory->getId()]['averageBidPrice'] = $firstLevelCategory->getAverageBidPrice();
        }
        return $firstLevelCategoryList;
    }
}