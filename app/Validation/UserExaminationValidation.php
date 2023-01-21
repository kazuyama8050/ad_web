<?php
namespace App\Validation;
use App\Models\UserExamination\UserExamination;
use \Symfony\Component\HttpFoundation\Response;
class UserExaminationValidation
{
    public function validateRegisterName($name) {
        if (mb_strlen($name) > UserExamination::MAX_NAME_LENGTH) {
            abort(response()->json(['message' => '30文字以内で入力してください。'], Response::HTTP_BAD_REQUEST));
            return false;
        }
        return true;
    }

    public function validateRegisterPhone($phone) {
        if (!preg_match(UserExamination::PHONE_PATTERN, $phone)) {
            abort(response()->json(['message' => '不正な電話番号の形式です。'], Response::HTTP_BAD_REQUEST));
            return false;
        }
        return true;
    }

    public function validateRegisterEmail($email) {
        if (!preg_match(UserExamination::EMAIL_PATTERN, $email)) {
            abort(response()->json(['message' => '不正なメールアドレスの形式です。'], Response::HTTP_BAD_REQUEST));
            return false;
        }
        return true;
    }

    public function validateJudgeUser($userExamination) {
        if (empty($userExamination)){abort(response()->json(['message' => '存在しない仮登録IDです。'], Response::HTTP_BAD_REQUEST));}
        if (!$userExamination->isBeforeReview()){abort(response()->json(['message' => '審査済みです。'], Response::HTTP_BAD_REQUEST));}

        return true;
    }
}