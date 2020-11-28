<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DaftarController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'email' => 'required',
            'password' => 'required',
            'kode' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response($validator->errors());
        }
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'kode' => $request->kode
        ]);
        return redirect(route('pembeli.index'))->with(['success' => 'admin Baru Ditambahkan']);
    }
}
