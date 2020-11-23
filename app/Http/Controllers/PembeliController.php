<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class PembeliController extends Controller
{
    public function index()
    {
        $User = User::all();
        $Order_details = [];
        return view('pembeli.index', compact('User'));
    }

}
