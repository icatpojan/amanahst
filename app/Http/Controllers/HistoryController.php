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
        return $this->sendResponse('Success', 'anda telah memesan', $Orders, 500);
    }

    public function detail($id)
    {
    	$order = Order::where('id', $id)->first();
    	$order_details = OrderDetail::where('order_id', $order->id)->get();

        //  return view('history.detail', compact('order','order_details'));
         return $this->sendResponse('Success', 'detail pesanan anda pak ekos', $order_details, 500);
    }
}
