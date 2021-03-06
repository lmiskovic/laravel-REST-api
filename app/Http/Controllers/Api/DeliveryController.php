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
		$data = Auth::user()->deliveries()->where('status', 'In progress')->get();
		return response()->json(['data' => $data], 200, [], JSON_NUMERIC_CHECK);
	}

	public function getAll(Request $request){
		$data = Delivery::all();
		return response()->json(['data' => $data], 200, [], JSON_NUMERIC_CHECK);
	}

	public function updateDelivery(Request $request){
		$id = $request->id;
		Delivery::where('id', $id)->update($request->all());
  		return response()->json([], 204);
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

	public function getDeliveryCounts(Request $request){
			//$users = DB::table('users')->select('id', 'name')->get();
			$data = array();

			$data['Inprogress'] = DB::table('deliveries')->where('status', 'In progress')->count();
			$data['Delivered'] = DB::table('deliveries')->where('status', 'Delivered')->count();
			$data['Canceled'] = DB::table('deliveries')->where('status', 'Canceled')->count();

			return response()->json(['data' => $data], 200, [], JSON_NUMERIC_CHECK);
		}

	public function setDelivered(Request $request){

		$id = $request->delivery_id;

		$delivery = Delivery::where('id','=',$id)->firstOrFail();

		if($delivery->status != 'In progress'){
		 return response()->json('',404);
		}

		DB::table('deliveries')
    		->where('id', $id)
    		->update(['status' => 'Delivered']);
		 return response()->json('',204);
	}

	public function createDelivery(Request $request){

		$this->validate($request, [
			    	'deliveryAddress' => 'required',
			    	'customerName' => 'required',
			    	'contactPhoneNumber' => 'required',
			    	'user_id' => 'required'
			    ]);

		$delivery = Delivery::create([
			'user_id' => request('user_id'),
    		'contactPhoneNumber' => request('contactPhoneNumber'),
    		'customerName' => request('customerName'),
    		'status' => request('status'),
    		'deliveryAddress' => request('deliveryAddress'),
    		'note' => request('note'),
    	]);

		 return response()->json([], 204);
    }

    public function deleteDelivery(Request $request){

		$id = $request->delivery_id;

		DB::table('deliveries')
    		->where('id', $id)
    		->delete();

		 return response()->json([], 204);
	}
}