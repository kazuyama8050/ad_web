<?php

namespace Tests\Helper;

Trait AdvertiserLoginTrait
{
    public static function userLogin($advertiserId, $advertiserStoreAccount) {
        session()->put('advertiserStoreAccount', $advertiserStoreAccount);
        session()->put('advertiserId', $advertiserId);
        return;
    }
}