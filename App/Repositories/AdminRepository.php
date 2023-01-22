<?php
namespace App\Repositories;
use Illuminate\Support\Facades\DB;
use App\Interfaces\AdminRepositoryInterface;
use App\Models\Admin\Admin;

class AdminRepository implements AdminRepositoryInterface
{
    public function getByEmail($email) {
        $admin = DB::table('admins')->where('email', $email)->first();
        return $this->rowMapper($admin, true);
    }

    private function rowMapper($row, $pass = false) {
        if (empty($row)) {
            return null;
        }

        $password = null;
        if ($pass) {
            $password = $row->password;
        }

        return new Admin(
            (int) $row->id,
            $password,
            $row->email,
            (int) $row->authority,
        );
    }
}