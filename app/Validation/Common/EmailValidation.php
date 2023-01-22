<?php
namespace App\Validation\Common;
use \Symfony\Component\HttpFoundation\Response;
class EmailValidation
{
    const EMAIL_PATTERN = "/^[a-zA-Z0-9!#\$%&`\+\*\-\/\^\{\}_\.]+@[a-zA-Z0-9!#\$%&`\+\*\-\/\^\{\}_\.]+\.[a-zA-Z0-9!#\$%&`\+\*\-\/\^\{\}_\.]+$/";
    public static function validateRegisterEmail($email) {
        if (!preg_match(self::EMAIL_PATTERN, $email)) {
            abort(response()->json(['message' => '不正なメールアドレスの形式です。'], Response::HTTP_BAD_REQUEST));
            return false;
        }
        return true;
    }
}