<?php
namespace App\Validation;
use App\Models\UserExamination\UserExamination;
use \Symfony\Component\HttpFoundation\Response;
class UserExaminationValidation
{
    public function validateRegisterName($name) {
        if (mb_strlen($name) > UserExamination::MaxNameLength) {
            abort(response()->json(['message' => '30文字以内で入力してください。'], Response::HTTP_BAD_REQUEST));
            return false;
        }
        return true;
    }

    public function validateRegisterPhone($phone) {
        if (!preg_match(UserExamination::PhonePattern, $phone)) {
            abort(response()->json(['message' => '不正な電話番号の形式です。'], Response::HTTP_BAD_REQUEST));
            return false;
        }
        return true;
    }

    public function validateRegisterEmail($email) {
        if (!preg_match(UserExamination::EmailPattern, $email)) {
            abort(response()->json(['message' => '不正なメールアドレスの形式です。'], Response::HTTP_BAD_REQUEST));
            return false;
        }
        return true;
    }
}