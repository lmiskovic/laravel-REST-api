<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Delivery;

class DeliveryController extends Controller
{
	public function index(){

		$data = Auth::user()->deliveries()->get();

		return response()->json(['data' => $data], 200, [], JSON_NUMERIC_CHECK);
	}

	public function setDelivered(Request $request){

		$id = $request->id;

		$delivery = Delivery::findOrFail($id);

		if($delivery->status != 'inProgress'){
			return response()->json(['delivery' => $delivery], 204, [], JSON_NUMERIC_CHECK);
		}

		DB::table('deliveries')
    		->where('id', $id)
    		->update(['status' => 'delivered']);
    	return response()->json(['delivery' => $delivery], 200, [], JSON_NUMERIC_CHECK);
	}
}