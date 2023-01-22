<?php

namespace Tests\Helper;

Trait AdvertiserLoginTrait
{
    public static function advertiserLogin($advertiserId = 1, $advertiserStoreAccount = 'store') {
        session()->put('advertiserStoreAccount', $advertiserStoreAccount);
        session()->put('advertiserId', $advertiserId);
        return;
    }
}