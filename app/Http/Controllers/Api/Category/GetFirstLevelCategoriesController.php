<?php

namespace App\Http\Controllers\Api\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\CategoryService;

class GetFirstLevelCategoriesController extends Controller
{
    /** @var CategoryService */
    private $categoryService;

    public function __construct(
        CategoryService $categoryService) {
        $this->categoryService = $categoryService;
    }
    public function get() {
        $firstLevelCategries = $this->categoryService->getFirstLevelCategories();
        return json_encode($firstLevelCategries);
    }
}
