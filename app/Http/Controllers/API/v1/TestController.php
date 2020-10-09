<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\API\APIController as Controller;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index(Request $request)
    {
        return $this->errorForbidden('This is an error', 419);
    }
}
