<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UserExaminationService;

class RegisterApplyFormController extends Controller
{
    /**
     * Summary of __construct
     * @param UserExaminationService $userExaminationService
     */
    private $userExaminationService;
    public function __construct(UserExaminationService $userExaminationService) {
        $this->userExaminationService = $userExaminationService;
    }

    public function create(Request $request) {
        $requestBody = $request->input();
        $lastName = isset($requestBody["lastName"]) ? $requestBody["lastName"] : null;
        $firstName = isset($requestBody["firstName"]) ? $requestBody["firstName"] : null;
        $phone = isset($requestBody["phone"]) ? $requestBody["phone"] : null;
        $email = isset($requestBody["email"]) ? $requestBody["email"] : null;
        $siteDomein = isset($requestBody["siteDomein"]) ? $requestBody["siteDomein"] : null;
        $category = isset($requestBody["category"]) ? $requestBody["category"] : null;

        $userExamination = $this->userExaminationService->registerForm(
            $lastName,
            $firstName,
            $phone,
            $email,
            $siteDomein,
            $category
        );

        return json_encode($userExamination);

    }
}