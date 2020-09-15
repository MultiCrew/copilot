<?php

namespace App\Http\Controllers\Flights;

use App\Http\Controller;
use Illuminate\Support\Facades\DB;

class RequestExpiryController extends Controller
{
    /**
     * Flush expired requests from the table.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        DB::delete('DELETE from flight_requests where acceptee_id is null and expiry < NOW()');
    }
}
