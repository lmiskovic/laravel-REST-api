<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Delivery;
use App\User;

class DeliveryController extends Controller
{
	public function getDeliveries(){
		$data = Auth::user()->deliveries()->get();
		return response()->json(['data' => $data], 200, [], JSON_NUMERIC_CHECK);
	}

	public function getAll(Request $request){
		$data = Delivery::all();
		return response()->json(['data' => $data], 200, [], JSON_NUMERIC_CHECK);
	}

	public function getDriverNames(Request $request){
		//$users = DB::table('users')->select('id', 'name')->get();
		$data = array();
		$users = DB::table('users')
					->select('user_id', 'name')
		            ->join('role_user', 'users.id', '=', 'role_user.user_id')
		            ->where('role_user.role_id','1')->get();
		foreach ($users as $users->user_id => $users->name) { 
		  $data[$users->user_id] = $users->name;
		}

		return response()->json(['data' => $data], 200, [], JSON_NUMERIC_CHECK);
	}

	public function setDelivered(Request $request){

		$id = $request->user_id;

		$delivery = Delivery::findOrFail($id);

		if($delivery->status != 'inProgress'){
			return response()->json(['delivery' => $delivery], 204, [], JSON_NUMERIC_CHECK);
		}

		DB::table('deliveries')
    		->where('id', $id)
    		->update(['status' => 'delivered']);
    	return response()->json(['delivery' => $delivery], 200, [], JSON_NUMERIC_CHECK);
	}

	public function createDelivery(Request $request){

		$delivery = Delivery::create([
			'user_id' => request('user_id'),
    		'contactPhoneNumber' => request('contactPhoneNumber'),
    		'customerName' => request('customerName'),
    		'deliveryAddress' => request('deliveryAddress'),
    		'note' => request('note'),
    	]);

		 return response()->json([], 204);
    }
}