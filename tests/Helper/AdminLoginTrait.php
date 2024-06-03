<?php

namespace Tests\Helper;

Trait AdminLoginTrait
{
    public static function adminLogin($adminId = 1, $adminEmail = 'admin1@email.com', $adminAuthority = 1) {
        session()->put('adminEmail', $adminEmail);
        session()->put('adminId', $adminId);
        session()->put('adminAuthority', $adminAuthority);
        return;
    }
}