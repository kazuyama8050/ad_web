<?php
namespace App\Validation;
use App\Models\Advertiser\Advertiser;
use \Symfony\Component\HttpFoundation\Response;
use App\Validation\Common\EmailValidation;
use App\Validation\Common\PhoneValidation;
use App\Validation\Common\ZipcodeValidation;
class AdvertiserValidation
{
    public function validateRegisterName($name) {
        if (mb_strlen($name) > Advertiser::MAX_NAME_LENGTH) {
            abort(response()->json(['message' => '名前は' . Advertiser::MAX_NAME_LENGTH . '文字以内で入力してください。'], Response::HTTP_BAD_REQUEST));
            return false;
        }
        return true;
    }

    public function validateRegisterStoreAccount($storeAccount) {
        if (mb_strlen($storeAccount) > Advertiser::MAX_STORE_ACCOUNT_LENGTH) {
            abort(response()->json(['message' => 'ストアアカウントは' . Advertiser::MAX_STORE_ACCOUNT_LENGTH . '文字以内で入力してください。'], Response::HTTP_BAD_REQUEST));
            return false;
        }
        return true;
    }

    public function validateRegisterZipcode($zipcode) {
        ZipcodeValidation::validateRegisterZipcode($zipcode);
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

    public function validateIsStopped(Advertiser $advertiser) {
        if ($advertiser->isAdvertiserStopped()){abort(response()->json(['message' => '停止中のアカウントです。'], Response::HTTP_BAD_REQUEST));}
    }
    public function validateIsRetire(Advertiser $advertiser) {
        if ($advertiser->isAdvertiserRetire()){abort(response()->json(['message' => '退会済みのアカウントです。'], Response::HTTP_BAD_REQUEST));}
    }
}