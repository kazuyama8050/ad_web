<?php
namespace App\Validation;
use App\Models\UserExamination\UserExamination;
use \Symfony\Component\HttpFoundation\Response;
use App\Validation\Common\EmailValidation;
use App\Validation\Common\PhoneValidation;
class UserExaminationValidation
{
    public function validateRegisterName($name) {
        if (mb_strlen($name) > UserExamination::MAX_NAME_LENGTH) {
            abort(response()->json(['message' => UserExamination::MAX_NAME_LENGTH . '文字以内で入力してください。'], Response::HTTP_BAD_REQUEST));
            return false;
        }
        return true;
    }

    public function validateRegisterPhone($phone) {
        PhoneValidation::validateRegisterPhone($phone);
        return true;
    }

    public function validateRegisterEmail($email) {
        EmailValidation::validateRegisterEmail($email);
        return true;
    }

    public function validateJudgeUser($userExamination) {
        if (empty($userExamination)){abort(response()->json(['message' => '存在しない仮登録IDです。'], Response::HTTP_BAD_REQUEST));}
        if (!$userExamination->isBeforeReview()){abort(response()->json(['message' => '審査済みです。'], Response::HTTP_BAD_REQUEST));}

        return true;
    }
}