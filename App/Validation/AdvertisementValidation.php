<?php
namespace App\Validation;
use App\Models\Advertisement\Advertisement;
use App\Models\Category\Category;
use \Symfony\Component\HttpFoundation\Response;
class AdvertisementValidation
{
    public function isExistAdvertisement($advertisement) {
        if (empty($advertisement)){abort(response()->json(['message' => '対象の広告は存在しません。'], Response::HTTP_NOT_FOUND));}
        return true;
    }

    public function validatePrice(Category $category, $price) {
        $floorPrice = $category->getFloorPrice();
        if ($floorPrice > $price) {
            abort(response()->json(['message' => "最低価格は${floorPrice}円です。"], Response::HTTP_BAD_REQUEST));
        }
        if ($price > Category::MAX_PRICE) {
            abort(response()->json(['message' => "最高価格は" . Category::MAX_PRICE . "円です。"], Response::HTTP_BAD_REQUEST));
        }
        return true;
    }

}