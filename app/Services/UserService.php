<?php
namespace App\Services;
use App\Repositories\UserRepository;
use App\Models\User\User;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;
use \Symfony\Component\HttpFoundation\Response;

class UserService
{
    /**
     * Summary of __construct
     * @param UserRepository $userRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function createUser($examinationId, $lastName, $firstName, $phone, $email){
        // 仮パスワード生成
        $password = $this->makeRandStr();
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $userId = $this->userRepository->create($examinationId, $passwordHash, $lastName, $firstName, $phone, $email);

        return [
            'password' => $password, 
            'userId' => $userId,
        ];

    }

    public function getById($userId) {
        $user = $this->userRepository->getById($userId);
        $userList = $this->createResponse($user);
        return $userList;
    }

    private function makeRandStr($length = 8) {
        $str = array_merge(range('a', 'z'), range('0', '9'), range('A', 'Z'));
        $r_str = null;
        for ($i = 0; $i < $length; $i++) {
            $r_str .= $str[rand(0, count($str) - 1)];
        }
        return $r_str;
    }

    private function createResponse(User $user) {
        $userList['examinationId'] = $user->getExaminationId();
        $userList['lastName'] = $user->GetLastName();
        $userList['firstName'] = $user->getFirstName();
        $userList['phone'] = $user->getPhone();
        $userList['email'] = $user->getEmail();
        $userList['zipcode'] = $user->getZipcode();
        $userList['address'] = $user->getAddress();
        $userList['paymentWay'] = $user->getPaymentWay();
        $userList['budget'] = $user->getBudget();
        $userList['isStopped'] = $user->getIsStopped();
        $userList['isRetire'] = $user->getIsRetire();

        return $userList;
    }
}