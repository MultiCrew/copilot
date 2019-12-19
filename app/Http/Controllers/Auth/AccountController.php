<?php

namespace App\Http\Controllers\Auth;

use \App\Http\Controllers\Controller as Controller;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * Show the user's account details in an editable form
     *
     * @return view
     */
    public function index()
    {
        return view('auth.account');
    }

    /**
     * Updates the authenticated user's account details
     *
     * @param      \Illuminate\Http\Request  $request  New account details
     */
    public function update(Request $request)
    {
        $user = \Auth::user();

        $input = $request->input();
        if ($input['password'] == null)
        {
            $request->user()->fill([
                'username'  => $request->username,
                'name'      => $request->name,
                'email'      => $request->email,
            ])->save();
        }
        else
        {
            if ($input['password'] === $input['password_conf'])
            {
                $request->user()->fill([
                    'username'  => $request->username,
                    'name'      => $request->name,
                    'email'      => $request->email,
                    'password' => \Hash::make($request->password)
                ])->save();
            }
            else
            {
                return view('auth.account', ['error' => 'password_mismatch']);
            }
        }

        return view('auth.account');
    }
}
