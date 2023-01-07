<?php
namespace App\Services;
use App\Repositories\UserExaminationRepository;
use App\Repositories\UserRepository;
use App\Interfaces\UserExaminationRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;
use App\Validation\UserExaminationValidation;
use App\Models\User\User;
use App\Models\UserExamination\UserExamination;
use \Symfony\Component\HttpFoundation\Response;

class UserExaminationService
{
    /**
     * Summary of __construct
     * @param UserExaminationRepository $userExaminationRepository
     */
    private $userExaminationRepository;

    /**
     * Summary of __construct
     * @param UserExaminationValidation $userExaminationValidation
     */
    private $userExaminationValidation;

    /**
     * Summary of userService
     * @var UserService $userService
     */
    private $userService;
    public function __construct(UserExaminationRepository $userExaminationRepository, UserExaminationValidation $userExaminationValidation, UserService $userService) {
        $this->userExaminationRepository = $userExaminationRepository;
        $this->userExaminationValidation = $userExaminationValidation;
        $this->userService = $userService;
    }

    public function getById($userExaminationId) {
        $userExamination = $this->userExaminationRepository->getById($userExaminationId);
        $userExaminationResponse = $this->createResponse($userExamination);
        return $userExaminationResponse;
    }

    public function registerForm($lastName, $firstName, $phone, $email, $siteDomein, $category) {
        if (empty($lastName)){abort(response()->json(['message' => '苗字は必須項目です。'], Response::HTTP_BAD_REQUEST));}
        if (empty($firstName)){abort(response()->json(['message' => '名前は必須項目です。'], Response::HTTP_BAD_REQUEST));}
        if (empty($phone)){abort(response()->json(['message' => '電話番号は必須項目です。'], Response::HTTP_BAD_REQUEST));}
        if (empty($email)){abort(response()->json(['message' => 'メールアドレスは必須項目です。'], Response::HTTP_BAD_REQUEST));}
        if (empty($siteDomein)){abort(response()->json(['message' => 'サイトドメインは必須項目です。'], Response::HTTP_BAD_REQUEST));}
        if (empty($category)){abort(response()->json(['message' => 'カテゴリは必須項目です。'], Response::HTTP_BAD_REQUEST));}

        $this->userExaminationValidation->validateRegisterName($lastName);
        $this->userExaminationValidation->validateRegisterName($firstName);
        $this->userExaminationValidation->validateRegisterPhone($phone);
        $this->userExaminationValidation->validateRegisterEmail($email);

        $emailCount = $this->userExaminationRepository->validateEmail($email);
        if (!empty($emailCount)){abort(response()->json(['message' => '登録済みのメールアドレスです。'], Response::HTTP_BAD_REQUEST));}

        $phoneCount = $this->userExaminationRepository->validatePhone($phone);
        if (!empty($phoneCount)){abort(response()->json(['message' => '登録済みの電話番号です。'], Response::HTTP_BAD_REQUEST));}

        try {
            DB::beginTransaction();
            $id = $this->userExaminationRepository->create($lastName, $firstName, $phone, $email, $siteDomein, $category);
            $userExamination = $this->getById($id);
            DB::commit();

            return $userExamination;

        } catch (\Throwable $e) {
            DB::rollBack();
        }
    }

    public function getDelivelerNoRegistered() {
        $userExaminationNoRegistered = $this->userExaminationRepository->getNoRegistered();
        $userExaminationNoRegisteredList = $this->createArrayResponse($userExaminationNoRegistered);
        return $userExaminationNoRegisteredList;
    }

    public function approveDeliveler($userExaminationId) {
        if (empty($userExaminationId)){abort(response()->json(['message' => '仮登録IDは必須です。'], Response::HTTP_NOT_FOUND));}

        $userExamination = $this->userExaminationRepository->getById($userExaminationId);
        $this->userExaminationValidation->validateJudgeDeliveler($userExamination);

        try {
            DB::beginTransaction();
            $this->userExaminationRepository->approve($userExaminationId);            
            
            $userData = $this->userService->createUser(
                $userExaminationId,
                $userExamination->getLastName(),
                $userExamination->getFirstName(),
                $userExamination->getPhone(),
                $userExamination->getEmail(),
            );

            DB::commit();

            //メール処理

            return $userData["userId"];
        } catch (\Throwable $e) {
            DB::rollBack();
        }
    }

    public function disapproveDeliveler($userExaminationId) {
        if (empty($userExaminationId)){abort(response()->json(['message' => '仮登録IDは必須です。'], Response::HTTP_NOT_FOUND));}

        $userExamination = $this->userExaminationRepository->getById($userExaminationId);
        $this->userExaminationValidation->validateJudgeDeliveler($userExamination);

        try{
            DB::beginTransaction();
            $this->userExaminationRepository->disapprove($userExaminationId);

            $userExamination = $this->getById($userExaminationId);
            DB::commit();

            //メール処理

            return $userExamination;

        } catch (\Throwable $e) {
            DB::rollBack();
        }
    }

    private function createResponse($userExamination) {
        $userExaminationResponse['id'] = $userExamination->getId();
        $userExaminationResponse['lastName'] = $userExamination->GetLastName();
        $userExaminationResponse['firstName'] = $userExamination->getFirstName();
        $userExaminationResponse['phone'] = $userExamination->getPhone();
        $userExaminationResponse['email'] = $userExamination->getEmail();
        $userExaminationResponse['siteDomein'] = $userExamination->getSiteDomein();
        $userExaminationResponse['category'] = $userExamination->getCategory();
        $userExaminationResponse['reviewFlag'] = $userExamination->getReviewFlag();

        return $userExaminationResponse;
    }

    private function createArrayResponse($userExaminations) {
        $userExaminationList = [];
        foreach ($userExaminations as $userExamination) {
            $userExaminationList[$userExamination->getId()]['lastName'] = $userExamination->GetLastName();
            $userExaminationList[$userExamination->getId()]['firstName'] = $userExamination->getFirstName();
            $userExaminationList[$userExamination->getId()]['phone'] = $userExamination->getPhone();
            $userExaminationList[$userExamination->getId()]['email'] = $userExamination->getEmail();
            $userExaminationList[$userExamination->getId()]['siteDomein'] = $userExamination->getSiteDomein();
            $userExaminationList[$userExamination->getId()]['category'] = $userExamination->getCategory();
            $userExaminationList[$userExamination->getId()]['reviewFlag'] = $userExamination->getReviewFlag();
        }

        return $userExaminationList;
    }
}