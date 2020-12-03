<?php

namespace App\Http\Controllers;

use App\Order;
use App\OrderDetail;
use App\Payment;
use App\Product;
use App\User;
use Illuminate\Http\Request;
use Auth;

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
        $Transaksi = Payment::avg('amount');
        $Customer = Auth::user()->name;
        $User = User::all()->count();
        $Order = OrderDetail::all()->count();
        $Payment = Payment::sum('amount');
        $Product = Product::all()->count();

        return view('home', compact('User', 'Order', 'Payment', 'Product', 'Customer', 'Transaksi'));
    }
    public function dash()
    {
        $Transaksi = Payment::avg('amount');
        $Customer = Auth::user()->name;
        $User = User::all()->count();
        $Order = OrderDetail::all()->count();
        $Payment = Payment::sum('amount');
        $Product = Product::all()->count();

        return view('home', compact('User', 'Order', 'Payment', 'Product', 'Customer', 'Transaksi'));
    }
}
