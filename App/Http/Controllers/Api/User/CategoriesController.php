<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CategoryService;

class CategoriesController extends Controller
{
    /**
     * Summary of __construct
     * @param CategoryService $categoryService
     */
    private $categoryService;
    public function __construct(CategoryService $categoryService) {
        $this->categoryService = $categoryService;
    }

    public function getAll(Request $request) {
        $categories = $this->categoryService->getAllCategories();

        return json_encode($categories);

    }
}