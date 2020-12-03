<?php

namespace App\Http\Controllers;

use App\Order;
use App\Payment;
use App\Product;
use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function dash()
    {
        $User = User::all()->count();
        $Order = Order::all()->count();
        $Payment = Payment::all()->count();
        $Product = Product::all()->count();
        return view('home', compact('User', 'Order', 'Payment', 'Product'));
    }
}
