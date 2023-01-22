<?php

namespace Tests\Helper;

Trait AdminLoginTrait
{
    public static function userLogin($adminId, $adminEmail, $adminAuthority = 1) {
        session()->put('adminEmail', $adminEmail);
        session()->put('adminId', $adminId);
        session()->put('adminAuthority', $adminAuthority);
        return;
    }
}