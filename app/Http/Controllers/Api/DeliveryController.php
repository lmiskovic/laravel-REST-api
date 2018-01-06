<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DeliveryController extends Controller
{
	public function index(){

		$data = Auth::user()->deliveries()->get();

		return response()->json(['data' => $data], 200, [], JSON_NUMERIC_CHECK);
	}
}