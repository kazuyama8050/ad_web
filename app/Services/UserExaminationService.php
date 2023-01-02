<?php
namespace App\Services;
use App\Repositories\UserExaminationRepository;
use App\Interfaces\UserExaminationRepositoryInterface;
use Illuminate\Support\Facades\DB;
use App\Interfaces\UserExaminationInterface;
use App\Validation\UserExaminationValidation;
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
    public function __construct(UserExaminationRepository $userExaminationRepository, UserExaminationValidation $userExaminationValidation) {
        $this->userExaminationRepository = $userExaminationRepository;
        $this->userExaminationValidation = $userExaminationValidation;
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
            $userExamination = $this->userExaminationRepository->getById($id);
            DB::commit();

            return [
                'id' => $userExamination->getId(),
                'lastName' => $userExamination->getLastName(),
                'firstName' => $userExamination->getFirstName(),
                'phone' => $userExamination->getPhone(),
                'email' => $userExamination->getEmail(),
                'siteDomein' => $userExamination->getSiteDomein(),
                'category' => $userExamination->getCategory(),
                'reviewFlag' => $userExamination->getReviewFlag(),
            ];

        } catch (\Throwable $e) {
            DB::rollBack();
        }
    }
}