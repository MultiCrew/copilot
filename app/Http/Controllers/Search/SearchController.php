<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Return all the airports in the database
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function airport(Request $request)
    {
        if ($request->ajax()) {
            $output = "";

            $airports = Airport::where('icao', 'LIKE', '%'. $request->search.'%')->orWhere('icao', 'LIKE', '%'. $request->search.'%');

            if($airports) {
                foreach ($airports as $key => $airport) {
                    $output .= '<option>'.
                    $airport->icao.
                    ' - '.
                    $airport->name.
                    '</option>';
                }
            }

            return $output;

        }
    }
}
