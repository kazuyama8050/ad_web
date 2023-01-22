<?php
namespace App\Validation\Common;
use \Symfony\Component\HttpFoundation\Response;
class ZipcodeValidation
{
    const ZIPCODE_PATTERN = "/\A\d{3}-?\d{4}\z/";
    public static function validateRegisterZipcode($zipcode) {
        if (!preg_match(self::ZIPCODE_PATTERN, $zipcode)) {
            abort(response()->json(['message' => '不正な郵便番号の形式です。'], Response::HTTP_BAD_REQUEST));
            return false;
        }
        return true;
    }
}