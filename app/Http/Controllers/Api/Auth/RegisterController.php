<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Client;

class RegisterController extends Controller
{
    use IssueTokenTrait;

	private $client;

	public function __construct(){
		$this->client = Client::find(1);
	}

    public function register(Request $request){

        $roleDriver = Role::where('name', 'Driver')->first();
        $roleDispathcer = Role::where('name', 'Dispatcher')->first();

    	$this->validate($request, [
    		'name' => 'required',
    		'email' => 'required|email|unique:users,email',
    		'password' => 'required|min:6'
    	]);

    	$user = User::create([
    		'name' => request('name'),
    		'email' => request('email'),
    		'password' => bcrypt(request('password')),
    	]);

        if(request('required_role') == 'Driver'){
            $user->roles()->attach($roleDriver->id);
        } else {
            $user->roles()->attach($roleDispathcer->id);
        }
        
    	return $this->issueToken($request, 'password');
    }
}
