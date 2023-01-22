<?php
namespace App\Services;
use App\Repositories\AdvertiserRepository;
use App\Validation\AdvertiserValidation;
use App\Models\Advertiser\Advertiser;
use App\Interfaces\AdvertiserRepositoryInterface;
use Illuminate\Support\Facades\DB;
use \Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use log;

class AdvertiserService
{
    /**
     * @param AdvertiserRepository $advertiserRepository
     */
    private $advertiserRepository;

    /**
     * @param AdvertiserValidation $advertiserValidation
     */
    private $advertiserValidation;

    public function __construct(AdvertiserRepository $advertiserRepository, AdvertiserValidation $advertiserValidation) {
        $this->advertiserRepository = $advertiserRepository;
        $this->advertiserValidation = $advertiserValidation;
    }

    public function loginCheck() {
        if (empty(session('advertiser'))) {
            header("Location:/advertiser/login");
        }
        return;
    }

    public function login($storeAccount, $password) {
        if (empty($storeAccount)){abort(response()->json(['message' => 'ストアアカウントは必須です。'], Response::HTTP_NOT_FOUND));}
        if (empty($password)){abort(response()->json(['message' => 'パスワードは必須です。'], Response::HTTP_NOT_FOUND));}

        $advertiser = $this->advertiserRepository->getByStoreAccount($storeAccount);
        if (empty($advertiser)){abort(response()->json(['message' => '登録されていないストアアカウントです。'], Response::HTTP_BAD_REQUEST));}

        $this->advertiserValidation->validateIsStopped($advertiser);
        $this->advertiserValidation->validateIsRetire($advertiser);

        $passwordHash = $advertiser->getPassword();
        if (!Hash::check($password, $passwordHash)){abort(response()->json(['message' => 'パスワードが一致しません。'], Response::HTTP_BAD_REQUEST));}

        return $advertiser;
    }

    public function createAdvertiser($storeAccount, $companyName, $companyZipcode, $companyAddress, $companySiteUrl,
                                    $managerLastName, $managerFirstName, $managerPhone, $managerEmail){

        if (empty($storeAccount)){abort(response()->json(['message' => 'ストアアカウントは必須です。'], Response::HTTP_NOT_FOUND));}
        if (empty($companyName)){abort(response()->json(['message' => '会社名は必須です。'], Response::HTTP_NOT_FOUND));}
        if (empty($companyZipcode)){abort(response()->json(['message' => '会社郵便番号は必須です。'], Response::HTTP_NOT_FOUND));}
        if (empty($companyAddress)){abort(response()->json(['message' => '会社住所は必須です。'], Response::HTTP_NOT_FOUND));}
        if (empty($companySiteUrl)){abort(response()->json(['message' => '会社サイトURLは必須です。'], Response::HTTP_NOT_FOUND));}
        if (empty($managerLastName)){abort(response()->json(['message' => '担当者苗字は必須です。'], Response::HTTP_NOT_FOUND));}
        if (empty($managerFirstName)){abort(response()->json(['message' => '担当者名前は必須です。'], Response::HTTP_NOT_FOUND));}
        if (empty($managerPhone)){abort(response()->json(['message' => '担当者電話番号は必須です。'], Response::HTTP_NOT_FOUND));}
        if (empty($managerEmail)){abort(response()->json(['message' => '担当者メールアドレスは必須です。'], Response::HTTP_NOT_FOUND));}

        $this->advertiserValidation->validateRegisterStoreAccount($storeAccount);
        $this->advertiserValidation->validateRegisterZipcode($companyZipcode);
        $this->advertiserValidation->validateRegisterName($managerLastName);
        $this->advertiserValidation->validateRegisterName($managerFirstName);
        $this->advertiserValidation->validateRegisterPhone($managerPhone);
        $this->advertiserValidation->validateRegisterEmail($managerEmail);

        $advertiser = $this->advertiserRepository->getByStoreAccount($storeAccount);
        if (!empty($advertiser)){abort(response()->json(['message' => '登録済みのストアアカウントです。'], Response::HTTP_BAD_REQUEST));}

        $advertiser = $this->advertiserRepository->getByManagerEmail($managerEmail);
        if (!empty($advertiser)){abort(response()->json(['message' => '登録済みのメールアドレスです。'], Response::HTTP_BAD_REQUEST));}

        try {
            DB::beginTransaction();
            // 仮パスワード生成
            $password = $this->makeRandStr();
            $passwordHash = Hash::make($password);
            $advertiserId = $this->advertiserRepository
                                ->create($passwordHash, $storeAccount, $companyName, $companyZipcode, $companyAddress, $companySiteUrl,
                                $managerLastName, $managerFirstName, $managerPhone, $managerEmail);

            $advertiser = $this->advertiserRepository->getById($advertiserId);

            //メール処理
            $this->sendCreateMail($advertiser, $password);

            DB::commit();

            return $advertiser;

        } catch (\Throwable $e) {
            DB::rollBack();
            abort(response()->json(['message' => '予期せぬエラーが発生しました。'], Response::HTTP_INTERNAL_SERVER_ERROR));
        }
        

    }

    public function getAllAdvertiser() {
        $advertisers = $this->advertiserRepository->getAll();
        $advertiserList = [];
        foreach ($advertisers as $advertiser) {
            $advertiserList[] = $this->createResponse($advertiser);
        }

        return $advertiserList;
    }

    public function getById($advertiserId) {
        $advertiser = $this->advertiserRepository->getById($advertiserId);
        $advertiserList = $this->createResponse($advertiser);
        return $advertiserList;
    }

    private function makeRandStr($length = 8) {
        $str = array_merge(range('a', 'z'), range('0', '9'), range('A', 'Z'));
        $r_str = null;
        for ($i = 0; $i < $length; $i++) {
            $r_str .= $str[rand(0, count($str) - 1)];
        }
        return $r_str;
    }

    private function sendCreateMail(Advertiser $advertiser, $password) {
        $email = $advertiser->getManagerEmail();
        Mail::send('mail.advertiser.createAdvertiser', [
            'companyName' => $advertiser->getCompanyName(),
            'storeAccount' => $advertiser->getStoreAccount(),
            'managerLastName' => $advertiser->getManagerLastname(),
            'managerFirstName' => $advertiser->getManagerFirstName(),
            'password' => $password,
        ], function ($message) use ($email) {
            $message->to($email)
                ->subject('アフィリエイト広告主登録');
        });
        if (count(Mail::failures()) > 0) {
            Log::channel('slack')->warning(Mail::failures());
            abort(response()->json(['message' => 'メール送信失敗に失敗しました。'], Response::HTTP_INTERNAL_SERVER_ERROR));
        };
    }

    private function createResponse(Advertiser $advertiser) {
        $advertiserList['id'] = $advertiser->getId();
        $advertiserList['storeAccount'] = $advertiser->getStoreAccount();
        $advertiserList['companyName'] = $advertiser->getCompanyName();
        $advertiserList['companyZipcode'] = $advertiser->getCompanyZipcode();
        $advertiserList['companyAddress'] = $advertiser->getCompanyAddress();
        $advertiserList['companySiteUrl'] = $advertiser->getCompanySiteUrl();
        $advertiserList['managerLastName'] = $advertiser->getLastName();
        $advertiserList['managerFirstName'] = $advertiser->getFirstName();
        $advertiserList['managerPhone'] = $advertiser->getPhone();
        $advertiserList['managerEmail'] = $advertiser->getEmail();
        $advertiserList['paymentWay'] = $advertiser->getPaymentWay();
        $advertiserList['budget'] = $advertiser->getBudget();
        $advertiserList['isStopped'] = $advertiser->getIsStopped();
        $advertiserList['isRetire'] = $advertiser->getIsRetire();

        return $advertiserList;
    }
}