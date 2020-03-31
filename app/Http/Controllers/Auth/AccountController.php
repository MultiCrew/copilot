<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \App\Http\Controllers\Controller as Controller;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the user's account details in an editable form
     *
     * @return view
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            $role = 'Admin';
        } else if ($user->hasRole('user')) {
            $role = 'Beta Tester';
        } else {
            $role = 'Regular User';
        }

        return view('auth.users.show', [
            'user' => $user,
            'role' => $role
        ]);
    }

    public function validator(array $data = [])
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'username' => ['required', 'string', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
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
            if ($input['password'] === $input['password_confirmation'])
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
