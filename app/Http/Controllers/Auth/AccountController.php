<?php

namespace App\Http\Controllers\Auth;

use \App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Users\UserNotification;

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
            'role' => $role,
            'userNotifications' => UserNotification::where('user_id', Auth::id())->first()
        ]);
    }

    /**
     * Updates the authenticated user's account details
     *
     * @param      \Illuminate\Http\Request  $request  New account details
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user->fill([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->save();

        return redirect()->route('account.index');
    }
}
