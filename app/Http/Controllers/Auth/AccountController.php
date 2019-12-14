<?php

namespace App\Http\Controllers\Auth;

use \App\Http\Controllers\Controller as Controller;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index()
    {
        return view('auth.account');
    }
}
