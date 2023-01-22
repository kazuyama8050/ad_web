<?php
namespace App\Services;
use App\Repositories\AdminRepository;
use App\Validation\AdminValidation;
use App\Models\Admin\Admin;
use App\Interfaces\AdminRepositoryInterface;
use Illuminate\Support\Facades\DB;
use \Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Hash;

class AdminService
{
    /**
     * @param AdminRepository $adminRepository
     */
    private $adminRepository;

    public function __construct(AdminRepository $adminRepository) {
        $this->adminRepository = $adminRepository;
    }

    public function loginCheck() {
        if (empty(session('admin'))) {
            header("Location:/admin/login");
        }
        return;
    }

    public function login($email, $password) {
        if (empty($email)){abort(response()->json(['message' => 'メールアドレスは必須です。'], Response::HTTP_NOT_FOUND));}
        if (empty($password)){abort(response()->json(['message' => 'パスワードは必須です。'], Response::HTTP_NOT_FOUND));}

        $admin = $this->adminRepository->getByEmail($email);
        if (empty($admin)){abort(response()->json(['message' => '登録されていないメールアドレスです。'], Response::HTTP_BAD_REQUEST));}

        $passwordHash = $admin->getPassword();
        if (!Hash::check($password, $passwordHash)){abort(response()->json(['message' => 'パスワードが一致しません。'], Response::HTTP_BAD_REQUEST));}

        return $admin;
    }

    private function createResponse(Admin $admin) {
        $adminList['id'] = $admin->getId();
        $adminList['email'] = $admin->getEmail();
        $adminList['authority'] = $admin->getAuthority();

        return $adminList;
    }
}