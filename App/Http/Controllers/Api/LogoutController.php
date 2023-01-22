<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function logout(Request $request) {
        $target = $request->target ? $request->target : null;

        if ($target === 'user') {
            $request->session()->forget('userId');
            $request->session()->forget('userEmail');
        }
        if ($target === 'advertiser') {
            $request->session()->forget('advertiserId');
            $request->session()->forget('advertiserStoreAccount');
        }
        if ($target === 'admin') {
            $request->session()->forget('adminId');
            $request->session()->forget('adminEmail');
        }

        return json_encode([
            'message' => 'OK'
        ]);
    }
}