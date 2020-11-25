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
        $Orders = Order::where('customer_id', Auth::user()->id)->where('status', '!=', 0)->get();
        return $this->sendResponse('Success', 'anda telah memesan', $Orders, 200);
    }

    public function detail($id)
    {
        $order = Order::where('id', $id)->first();
        $order_details = OrderDetail::where('order_id', $order->id)->get();

        //  return view('history.detail', compact('order','order_details'));
        return $this->sendResponse('Success', 'detail pesanan anda pak ekos', $order_details, 500);
    }
    public function klien()
    {
        $id = Auth::user()->id;
        $Order_details = [];

        $Order = OrderDetail::with(['product:id,name,customer_id', 'order:id,status,customer_id'])->whereHas('product', function ($q) use ($id) {
            return $q->where('customer_id', $id);
        })->get();
        $Order_details = $Order->where('product.customer_id', $id)->where('order.status', 2);
        return $this->sendResponse('success', 'daftar pemesan barang', $Order_details, 200);
    }
    public function accept($id)
    {
        $order_detail = OrderDetail::find($id);
        $order_detail->status = 3;
        $order_detail->update();
        return $this->sendResponse('Success', 'barang sudah anda terima', null, 200);
    }
}
