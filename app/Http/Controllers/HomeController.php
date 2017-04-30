<?php

namespace App\Http\Controllers;

use FullStack;
use Illuminate\Http\Request;
use App\User;

class HomeController extends Controller
{

	public function getAllUsers()
	{
		$users = User::all();
		return response()->json(['users' => $users, 'emails' => []], 200);
	}

	public function getUserInfo(Request $request)
	{
		$user = User::find($request->id);
		return response()->json($user, 200);
	}

	public function updateUserInfo(Request $request)
	{
		$user = User::find($request->id);
		$user->name = $request->name;
		$user->email = $request->email;
		if($request->password) {
			$user->password = bcrypt($request->password);
		}
		$user->save();
	}

	public function deleteUser(Request $request)
	{
		$user = User::find($request->id);
		$user->delete();
	}

	public function index()
	{
		$users = User::all();
		return view('index', compact('users'));
	}

    public function store(Request $request)
    {

    	// dd($request->avatar);



    	$user = new User;
    	$user->name     = $request->name;
    	$user->email    = $request->email;
    	$user->password = bcrypt($request->password);
    	$user->avatar   = FullStack::uploadImage('avatar', 'public/images/avatar');
    	if($user->save()) {
    		return response()->json($user, 200);
    	}

    }

    public function search(Request $request)
    {
    	$key   = $request->search;
    	$users = User::where('name', 'LIKE', '%'.$key.'%')->get();
    	return response()->json($users, 200);
    }
}
