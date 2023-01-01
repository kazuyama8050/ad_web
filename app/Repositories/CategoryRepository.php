<?php
namespace App\Repositories;
use Illuminate\Support\Facades\DB;
use App\Interfaces\CategoryRepositoryInterface;
use App\Models\Category\Category;

class CategoryRepository implements CategoryRepositoryInterface {
    private $categoryColumns = [
        "id",
        'name',
        'level',
        'parent_id',
        'floor_price',
        'average_bid_price',
    ];

    public function getFirstLevelCatgories() {
        $columns = join(',', $this->categoryColumns);
        $firstLevelCategories = DB::table('categories')
            ->where('level', 1)
            ->get();
        
        $firstLevelCategoryList = array();
        foreach ($firstLevelCategories as $firstLevelCategory) {
            $firstLevelCategoryList[] = $this->rowMapper($firstLevelCategory);
        }
        return $firstLevelCategoryList;
    }
    

    /**
     * Summary of rowMapper
     * @param mixed $row
     * @return Category|null
     */
    private function rowMapper($row) {
        if (empty($row)) {
            return null;
        }
        return new Category(
            (int) $row->id,
            $row->name,
            (int) $row->level,
            (int) $row->parent_id,
            (int) $row->floor_price,
            $row->average_bid_price,
        );
    }
}