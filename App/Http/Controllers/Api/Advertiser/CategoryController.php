<?php

namespace App\Http\Controllers\Api\Advertiser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\CategoryService;

class CategoryController extends Controller
{
    /** @var CategoryService */
    private $categoryService;

    public function __construct(
        CategoryService $categoryService) {
        $this->categoryService = $categoryService;
    }
    public function getAll(Request $request) {
        $advertiserId = $request->advertiserId;
        $firstLevelCategries = $this->categoryService->getAllCategories();
        return json_encode($firstLevelCategries);
    }
}
