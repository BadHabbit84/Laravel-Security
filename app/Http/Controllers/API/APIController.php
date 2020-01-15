<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use Illuminate\Support\Facades\Auth;

class APIController extends Controller
{
    //

    public function register(Request $request) {

    	
    	$validated_data = $request->validate([
    		'name' => 'required|max:3',
    		'email' => 'email|required',
    		'password' => 'required'
    	]);

    	$validated_data['password'] = bcrypt($validated_data['password']);

    	$user = User::create($validated_data);

    	$token = $user->createToken('auth_token')->accessToken;

    	return response([
    		'user' => $user,
    		'token' => $token
    	]);

    }

    public function login(Request $request) {

    	$validated_data = $request->validate([
    		'password' => 'required',
    		'email' => 'required'
    	]);

    	if (!auth()->attempt($validated_data)) {
    		return response(['message'=>'Wrong data BRO!!!!']);
    	}

    	$token = Auth::user()->createToken('token')->accessToken;

    	return response([
    		'user' => auth::user(),
    		'token' => $token
    	]);


    }
}
