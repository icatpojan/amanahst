<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DoctController extends Controller
{
    public function index()
    {
        return view('doct');
    }
}
