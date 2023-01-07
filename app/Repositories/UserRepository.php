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

    public function getById($userId) {
        $user = DB::table('users')->where('id', $userId)->first();
        return $this->rowMapper($user);
    }

    private function rowMapper($row) {
        if (empty($row)) {
            return null;
        }

        return new User(
            (int) $row->id,
            (int) $row->examination_id,
            null,
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