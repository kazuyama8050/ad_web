<?php
namespace App\Validation\Common;
use \Symfony\Component\HttpFoundation\Response;
class PhoneValidation
{
    const PHONE_PATTERN = "/^[0-9]{2,4}-[0-9]{2,4}-[0-9]{3,4}$/";
    public static function validateRegisterPhone($phone) {
        if (!preg_match(self::PHONE_PATTERN, $phone)) {
            abort(response()->json(['message' => '不正な電話番号の形式です。'], Response::HTTP_BAD_REQUEST));
            return false;
        }
        return true;
    }
}