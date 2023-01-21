<?php
namespace App\Services;
use App\Repositories\UserRepository;
use App\Validation\UserValidation;
use App\Models\User\User;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;
use \Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Hash;

class UserService
{
    /**
     * @param UserRepository $userRepository
     */
    private $userRepository;

    /**
     * @param UserValidation $userValidation
     */
    private $userValidation;

    public function __construct(UserRepository $userRepository, UserValidation $userValidation) {
        $this->userRepository = $userRepository;
        $this->userValidation = $userValidation;
    }

    public function loginCheck() {
        if (empty(session('user'))) {
            header("Location:/user/login");
        }
        return;
    }

    public function login($email, $password) {
        if (empty($email)){abort(response()->json(['message' => 'メールアドレスは必須です。'], Response::HTTP_NOT_FOUND));}
        if (empty($password)){abort(response()->json(['message' => 'パスワードは必須です。'], Response::HTTP_NOT_FOUND));}

        $user = $this->userRepository->getByEmail($email);
        if (empty($user)){abort(response()->json(['message' => '登録されていないメールアドレスです。'], Response::HTTP_BAD_REQUEST));}

        $this->userValidation->validateIsStopped($user);
        $this->userValidation->validateIsRetire($user);

        $passwordHash = $user->getPassword();
        if (!Hash::check($password, $passwordHash)){abort(response()->json(['message' => 'パスワードが一致しません。'], Response::HTTP_BAD_REQUEST));}

        return $user;
    }

    public function createUser($examinationId, $lastName, $firstName, $phone, $email){
        // 仮パスワード生成
        $password = $this->makeRandStr();
        $passwordHash = Hash::make($password);
        $userId = $this->userRepository->create($examinationId, $passwordHash, $lastName, $firstName, $phone, $email);

        return [
            'password' => $password, 
            'userId' => $userId,
        ];

    }

    public function getAllUser() {
        $users = $this->userRepository->getAll();
        $userList = [];
        foreach ($users as $user) {
            $userList[] = $this->createResponse($user);
        }

        return $userList;
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
        $userList['id'] = $user->getId();
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