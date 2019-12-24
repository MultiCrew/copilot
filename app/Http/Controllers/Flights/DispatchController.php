<?php

namespace App\Http\Controllers\Flights;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Flights\Flight;

class DispatchController extends Controller
{
    public function plan($id)
    {
        return view('flights.dispatch.plan', ['flight' => Flight::findOrFail($id)]);
    }
}
