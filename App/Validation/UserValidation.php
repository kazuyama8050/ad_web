<?php
namespace App\Validation;
use App\Models\User\User;
use \Symfony\Component\HttpFoundation\Response;
class UserValidation
{
    public function validateIsStopped(User $user) {
        if ($user->isUserStopped()){abort(response()->json(['message' => '停止中のアカウントです。'], Response::HTTP_BAD_REQUEST));}
    }
    public function validateIsRetire(User $user) {
        if ($user->isUserRetire()){abort(response()->json(['message' => '退会済みのアカウントです。'], Response::HTTP_BAD_REQUEST));}
    }
}