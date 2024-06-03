<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AdminService;
use Illuminate\Support\Facades\Route;

class LoginAdminController extends Controller
{
    /**
     * Summary of __construct
     * @param AdminService $adminService
     */
    private $adminService;
    public function __construct(AdminService $adminService) {
        $this->adminService = $adminService;
    }

    public function login(Request $request) {
        $requestBody = $request->input();
        $email = isset($requestBody["email"]) ? $requestBody["email"] : null;
        $password = isset($requestBody["password"]) ? $requestBody["password"] : null;

        $admin = $this->adminService->login(
            $email,
            $password,
        );

        $request->session()->put('adminEmail', $admin->getEmail());
        $request->session()->put('adminId', $admin->getId());
        $request->session()->put('adminAuthority', $admin->getAuthority());

        return json_encode(['message' => 'OK']);

    }

    public function loginCheck() {
        $this->adminService->loginCheck();
        return json_encode(['message' => 'OK']);
    }
}