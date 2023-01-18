<?php

namespace Tests\Helper;

Trait DelivelerLoginTrait
{
    public static function delivelerLogin($delivelerId, $delivelerEmail) {
        session()->put('delivelerEmail', $delivelerEmail);
        session()->put('delivelerId', $delivelerId);
        return;
    }
}