<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

<<<<<<< HEAD
    public function policy()
    {
=======
    public function about()
    {
        return view('about');
    }

    public function policy()
    {
>>>>>>> dev
        return view('policy');
    }
}
