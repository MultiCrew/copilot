<?php

namespace App\Http\Controllers\Flights;

use App\Models\Users\User;
use Illuminate\Http\Request;
use App\Models\Flights\Flight;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class APIController extends Controller
{
    /**
     * Search the database for flights, based on a query parameter if given in the request
     * Method can be called either in ajax or PHP, see below
     *
     * @param      \Illuminate\Http\Request     $request
     *                                              ->ajax()    If JSON array required
     *                                                          Otherwise PHP array returned
     * @return     JSON Array | PHP array       Array of flights found based on request
     */
    public function search(Request $request)
    {  
        $output = '';
        if($request->path() == 'api/search'){
            $query = $request->get('query')[0];
        }
        else{
            $query = $request->get('query');
        }
        if($query != '')
        {
            $data =
                DB::table('flights')
                ->where('public', 1)
                ->where(function ($q) use ($query){
                    $q->where('departure', 'like', '%'.$query.'%')
                    ->orWhere('arrival', 'like', '%'.$query.'%')
                    ->orWhere('aircraft', 'like', '%'.$query.'%')
                    ->where('public', 1);
                })
                ->orderBy('id', 'asc')
                ->get();
        }
        else
        {
            $data =
                Flight::get()
                ->where('public', 1)
                ->sortBy('id');
        }
        if($request->ajax())
            echo json_encode($data);
        else
            return $data;
    }

    /**
     * Create a new flight
     *
     * @param      \Illuminate\Http\Request     $request
     * @return     JSON Array | PHP array       Array of flights found based on request
     */
    public function store(Request $request)
    {
        $flight = new Flight();
        $user = User::where('discord_id', $request->discord_id)->first();
        if(!$user) {
            return $user;
        }

        $flight->fill([
            'departure' => $request->departure,
            'arrival'   => $request->arrival,
            'aircraft'  => $request->aircraft
        ]);
        $flight->requestee_id = $user->id;
        $flight->public = true;
        $flight->save();
        
        $flight = $flight->fresh();
        return $flight;
    }
}
