<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\UserService;

class AdminUserController extends Controller
{
    /** @var UserService */
    private $userSerice;
    
    public function __construct(UserService $userSerice) {
        $this->userSerice = $userSerice;
    }
    public function getAll() {
        $user = $this->userSerice->getAllUser();
        return json_encode($user);
    }
}
