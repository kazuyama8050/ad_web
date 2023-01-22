<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Support\Facades\Route;

class LoginUserController extends Controller
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

        $user = $this->userService->login(
            $email,
            $password,
        );

        $request->session()->put('userEmail', $user->getEmail());
        $request->session()->put('userId', $user->getId());

        return json_encode(['message' => 'OK']);

    }

    public function loginCheck() {
        $this->userService->loginCheck();
        return json_encode(['message' => 'OK']);
    }
}