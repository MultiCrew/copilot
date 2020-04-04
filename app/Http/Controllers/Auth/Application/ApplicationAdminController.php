<?php

namespace App\Http\Controllers\Auth\Application;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Users\ApplicationForm;

class ApplicationAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('auth.applications.index', [
            'pendingApplications' => ApplicationForm::where('status', '=', 'pending')->with('user')->get()
        ]);
    }

    /**
     * Show the specified resource
     *
     * @return \Illuminate\Http\Response
     */
    public function show(ApplicationForm $application)
    {
        return view('auth.applications.show', ['application' => $application]);
    }

    public function update(Request $request, ApplicationForm $application)
    {
        $application->status = $request->status;
        $application->save();

        if ($request->status === 'approved') {
            $application->user->assignRole('user');
        } else {
            $application->user->givePermissionTo('apply to beta');
        }

        return redirect()->route('admin.applications.index');
    }
}
