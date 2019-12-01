<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;

class LegalController extends Controller
{
    public function cookieConsent()
    {
        Cookie::queue('cookie_consent', true);
        return redirect()->back();
    }
}
