<?php

namespace App\Http\Controllers;

use Auth;
use Alert;
use App\User;
use Illuminate\Http\Request;
use Hash;
use GuzzleHttp\Client;

class ProfileController extends Controller
{
	public function index()
	{
		$user = User::where('id', Auth::user()->id)->first();
		if (Empty($user)) {
			return response('silakan login terlebih dahulu pak eko');
		}
		return $this->sendResponse('Succes', 'ini dia profil anda pak eko', $user, 500);
		// return view('profile.index', compact('user'));
	}

	public function update(Request $request)
	{
		$this->validate($request, [
			'password'  => 'confirmed',
		]);
		// $user = User::find($id);
		$image = null;

		if ($request->image) {
			// $image = $request->image->getClientOriginalName() . '-' . time() . '.' . $request->image->extension();
			// $request->image->move(public_path('img'), $image);

			$img = base64_encode(file_get_contents($request->image));
			$client = new Client();
			$res = $client->request('POST', 'https://freeimage.host/api/1/upload', [
				'form_params' => [
					'key' => '6d207e02198a847aa98d0a2a901485a5',
					'action' => 'upload',
					'source' => $img,
					'format' => 'json',
				]
			]);
			$array = json_decode($res->getBody()->getContents());
			// dd($array);
			$image = $array->image->file->resource->chain->image;
		}
		$user = User::where('id', Auth::user()->id)->first();
		$user->name = $request->name;
		$user->email = $request->email;
		$user->image = $image;
		$user->nomor_telpon = $request->nomor_telpon;
		$user->alamat = $request->alamat;

		if (!empty($request->password)) {
			$user->password = Hash::make($request->password);
		}

		$user->update();
		return $this->sendResponse('Success', 'profile anda di upgrade pak eko', $user, 500);
	}
}
