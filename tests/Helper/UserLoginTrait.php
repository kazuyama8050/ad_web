<?php

namespace Tests\Helper;

Trait UserLoginTrait
{
    public static function userLogin($userId, $userEmail) {
        session()->put('userEmail', $userEmail);
        session()->put('userId', $userId);
        return;
    }
}