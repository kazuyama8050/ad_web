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
        'is_delete',
    ];

    public function getById($categoryId) {
        $category = DB::table('categories')->where('id', $categoryId)->first();
        return $this->rowMapper($category);
    }

    public function getFirstLevelCatgories() {
        $columns = join(',', $this->categoryColumns);
        $firstLevelCategories = DB::table('categories')
            ->where('level', 1)
            ->where('is_delete', 0)
            ->get();
        
        $firstLevelCategoryList = array();
        foreach ($firstLevelCategories as $firstLevelCategory) {
            $firstLevelCategoryList[] = $this->rowMapper($firstLevelCategory);
        }
        return $firstLevelCategoryList;
    }

    public function getAllCategories() {
        $allCategories = DB::table('categories')->where('is_delete', 0)->get();
        $categoryList = array();
        foreach ($allCategories as $category) {
            $categoryList[] = $this->rowMapper($category);
        }
        return $categoryList;
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
            (int) $row->is_delete,
        );
    }
}