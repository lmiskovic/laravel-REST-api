<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DriverController extends Controller
{
    public function updateLastLocation(Request $request){
    	
    	$lastLocation = $request->lastLocation;
		Auth::user()->update(['lastLocation' => $lastLocation]);
		return response()->json([], 204);
    }

    public function getLastLocations(Request $request){
    	$data = array();

		$locations = DB::table('users')
							->select('lastLocation', 'name')
							->whereNotNull('lastLocation')
							->get();
		foreach ($locations as $locations->name => $locations->lastLocation) { 
			$data[$locations->name] = $locations->lastLocation;
		}

		return response()->json(['data' => $data], 200, [], JSON_NUMERIC_CHECK);
    }
}
