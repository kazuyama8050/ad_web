<?php

namespace Tests\Helper;

Trait UserLoginTrait
{
    public static function userLogin($userId = 1, $userEmail = 'user1@email.com') {
        session()->put('userEmail', $userEmail);
        session()->put('userId', $userId);
        return;
    }
}