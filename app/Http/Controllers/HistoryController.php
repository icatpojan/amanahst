<?php

namespace App\Http\Controllers;
use App\Product;
use App\Order;
use App\User;
use App\OrderDetail;
use Auth;
use Alert;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index()
    {
    	$Orders = Order::where('customer_id', Auth::user()->id)->where('status', '!=',0)->get();

        // return view('history.index', compact('pesanans'));
        return $this->sendResponse('Success', 'anda telah memesan', $Orders, 500);
    }

    public function detail($id)
    {
    	$pesanan = Order::where('id', $id)->first();
    	$pesanan_details = OrderDetail::where('pesanan_id', $pesanan->id)->get();

     	return view('history.detail', compact('pesanan','pesanan_details'));
    }
}
