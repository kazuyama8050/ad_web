<?php
namespace App\Validation;
use App\Models\Category\Category;
use \Symfony\Component\HttpFoundation\Response;
class CategoryValidation
{
    public function isExistCategory($category) {
        if (empty($category)){abort(response()->json(['message' => '対象のカテゴリは存在しません。'], Response::HTTP_NOT_FOUND));}
        return true;
    }
}