<?php
namespace App\Repositories;
use Illuminate\Support\Facades\DB;
use App\Interfaces\UserExaminationRepositoryInterface;
use App\Models\UserExamination\UserExamination;

class UserExaminationRepository implements UserExaminationRepositoryInterface
{
    private $userExaminationColumns = [
        'id',
        'last_name',
        'first_name',
        'phone',
        'email',
        'site_domein',
        'category',
        'review_flag',
    ];

    public function getById($id) {
        $columns = join(',', $this->userExaminationColumns);
        $userExamination = DB::table('user_examinations')->where('id', $id)->first();
        return $this->rowMapper($userExamination);
    }

    public function getAll() {
        $userExaminations = DB::table('user_examinations')->get();
        $userExaminationList = array();
        foreach ($userExaminations as $userExamination) {
            $userExaminationList[] = $this->rowMapper($userExaminations);
        }
        return $userExaminationList;
    }

    public function validateEmail($email) {
        $userExaminationCount = DB::table('user_examinations')
            ->where('email', $email)
            ->whereNotIn('review_flag', [UserExamination::REVIEW_NG])
            ->count();
        return $userExaminationCount;
    }

    public function validatePhone($phone) {
        $userExaminationCount = DB::table('user_examinations')
            ->where('phone', $phone)
            ->whereNotIn('review_flag', [UserExamination::REVIEW_NG])
            ->count();
        return $userExaminationCount;
    }

    public function create($lastName, $firstName, $phone, $email, $siteDomein, $category) {
        $id = DB::table('user_examinations')->insertGetId([
            'last_name' => $lastName,
            'first_name' => $firstName,
            'phone' => $phone,
            'email' => $email,
            'site_domein' => $siteDomein,
            'category' => $category,
            'review_flag' => UserExamination::REVIEW_BEFORE,
        ]);

        return $id;
    }

    private function rowMapper($row) {
        if (empty($row)) {
            return null;
        }
        return new UserExamination(
            (int) $row->id,
            $row->last_name,
            $row->first_name,
            $row->phone,
            $row->email,
            $row->site_domein,
            $row->category,
            (int) $row->review_flag,
        );
    }
}