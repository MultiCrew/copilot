<?php

namespace App\Http\Controllers\Flights;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Flights\FlightRequest;

class SearchController extends Controller
{
    /**
     * Display homepage.
     *
     * @return \Illuminate\Http\Response
     */
	public function index()
	{
		$flights = FlightRequest::all();
		return view('flight.index', ['flights' => $flights]);
	}

	/**
	 * Live search
	 * 
	 * @return \Illuminate\Http\Response
	 */
	public function search(Request $request)
	{
		if($request->ajax())
     {
      $output = '';
      $query = $request->get('query');
      if($query != '')
      {
       $data = DB::table('flight_requests')
         ->where('departure', 'like', '%'.$query.'%')
         ->orWhere('arrival', 'like', '%'.$query.'%')
         ->orWhere('aircraft', 'like', '%'.$query.'%')
         ->orderBy('id', 'asc')
         ->get();
         
      }
      else
      {
       $data = DB::table('flight_requests')
         ->orderBy('id', 'asc')
         ->get();
      }
      $total_row = $data->count();
      if($total_row > 0)
      {
       foreach($data as $row)
       {
        $output .= '
        <tr>
         <td>'.$row->id.'</td>
         <td>'.$row->departure.'</td>
         <td>'.$row->arrival.'</td>
         <td>'.$row->aircraft.'</td>
         <td><a href="#" class="btn btn-secondary btn-lg active" role="button" aria-pressed="true">Join</a></td>
        </tr>
        ';
       }
      }
      else
      {
       $output = '
       <tr>
        <td align="center" colspan="5">No Data Found</td>
       </tr>
       ';
      }
      $data = array(
       'table_data'  => $output
      );

      echo json_encode($data);
     }
	}
}
