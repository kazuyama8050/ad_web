<?php
namespace App\Interfaces;

use App\Models\Category\Category;
interface CategoryRepositoryInterface
{
    /**
     * Summary of getFirstLevelCatgories
     * @return array(Category)
     */
    public function getFirstLevelCatgories();
}