<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\UserExaminationService;
use App\Services\UserService;

class UserNoRegisteredController extends Controller
{
    /** @var UserExaminationService */
    private $userExaminationService;

    /** @var UserService */
    private $userSerice;
    
    public function __construct(UserExaminationService $userExaminationService, UserService $userSerice) {
        $this->userExaminationService = $userExaminationService;
        $this->userSerice = $userSerice;
    }
    public function get() {
        $userExaminations = $this->userExaminationService->getUserNoRegistered();
        return json_encode($userExaminations);
    }

    public function approve(Request $request) {
        $param = $request->input();
        $userExaminationId = isset($param["userExaminationId"]) ? $param["userExaminationId"] : null;
        $userId = $this->userExaminationService->approveUser($userExaminationId);

        $user = $this->userSerice->getById($userId);
        
        return json_encode($user);
    }

    public function disapprove(Request $request) {
        $param = $request->input();
        $userExaminationId = isset($param["userExaminationId"]) ? $param["userExaminationId"] : null;
        $userExamination = $this->userExaminationService->disapproveUser($userExaminationId);
        return json_encode($userExamination);
    }
}
