<?php
namespace App\Repositories;
use Illuminate\Support\Facades\DB;
use App\Interfaces\UserRepositoryInterface;
use App\Models\User\User;

class UserRepository implements UserRepositoryInterface
{
    public function create($examinationId, $passwordHash, $lastName, $firstName, $phone, $email) {
        $userId = DB::table('users')->insertGetId([
            'examination_id' => $examinationId,
            'password' => $passwordHash,
            'last_name' => $lastName,
            'first_name' => $firstName,
            'phone' => $phone,
            'email' => $email,
            'is_stopped' => User::NO_STOPPED,
            'is_retire' => User::NO_RETIRE,
        ]);

        return $userId;
    }

    public function getAll() {
        $users = DB::table('users')->where(['is_stopped'=>User::NO_STOPPED, 'is_retire'=>User::NO_RETIRE])->get();
        $userList = [];
        foreach ($users as $user) {
            $userList[] = $this->rowMapper($user);
        }
        return $userList;
    }

    public function getById($userId) {
        $user = DB::table('users')->where('id', $userId)->first();
        return $this->rowMapper($user);
    }

    public function getByEmail($email) {
        $user = DB::table('users')->where('email', $email)->first();
        return $this->rowMapper($user, true);
    }

    private function rowMapper($row, $pass = false) {
        if (empty($row)) {
            return null;
        }

        $password = null;
        if ($pass) {
            $password = $row->password;
        }

        return new User(
            (int) $row->id,
            (int) $row->examination_id,
            $password,
            $row->last_name,
            $row->first_name,
            $row->phone,
            $row->email,
            $row->zipcode,
            $row->address,
            (int) $row->payment_way,
            (int) $row->budget,
            (int) $row->is_stopped,
            (int) $row->is_retire,
        );
    }
}