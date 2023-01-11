<?php

namespace App\Http\Controllers\Api\Deliveler;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UserService;

class LoginDelivelerController extends Controller
{
    /**
     * Summary of __construct
     * @param UserService $userService
     */
    private $userService;
    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }

    public function login(Request $request) {
        $requestBody = $request->input();
        $email = isset($requestBody["email"]) ? $requestBody["email"] : null;
        $password = isset($requestBody["password"]) ? $requestBody["password"] : null;

        $this->userService->login(
            $email,
            $password,
        );

        return json_encode(['message' => 'OK']);

    }
}