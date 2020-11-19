<?php

namespace App\Http\Controllers;
use Auth;
use Alert;
use App\User;
use Illuminate\Http\Request;
use Hash;

class ProfileController extends Controller
{
    public function index()
    {
    	$user = User::where('id', Auth::user()->id)->first();
		return $this->sendResponse('Succes', 'ini dia profil anda pak eko', $user, 500);
    	// return view('profile.index', compact('user'));
    }

    public function update(Request $request)
    {
    	 $this->validate($request, [
            'password'  => 'confirmed',
        ]);

    	$user = User::where('id', Auth::user()->id)->first();
		$user->name = $request->name;
		$user->image = $request->image;
    	$user->email = $request->email;
    	$user->nomor_telpon = $request->nomor_telpon;
    	$user->alamat = $request->alamat;
    	if(!empty($request->password))
    	{
    		$user->password = Hash::make($request->password);
    	}
    	
    	$user->update();
        return $this->sendResponse('Success', 'profile anda di upgrade pak eko', $user, 500);
    }
}
