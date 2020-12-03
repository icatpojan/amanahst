<?php

namespace App\Http\Controllers;

use App\Product;
use App\Order;
use App\User;
use App\OrderDetail;
use Auth;
use Alert;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{

    public function index()
    {
        // $Order = Order::where('customer_id', Auth::user()->id)->where('status', 0)->first();

        $Order = Order::all();
        $Order_details = [];
        return view('transaksi.index', compact('Order'));
    }

    public function destroy($id)
    {
        $Order = Order::where('id', $id)->first();
        if (!$Order) {
            return $this->sendResponse('error', 'data tidak ada', null, 200);
        }
        $Order->delete();

        return view('transaksi.index', compact('Order'));;
    }

    public function konfirmasi()
    {
        $user = User::where('id', Auth::user()->id)->first();

        if (empty($user->alamat)) {
            return $this->sendResponse('error', 'isi alamat dulu pak eko', null, 200);
            return redirect('profile');
        }

        if (empty($user->nomor_telpon)) {
            return $this->sendResponse('error', 'isi identitas dulu pak eko', null, 200);
            return redirect('profile');
        }

        $Order = Order::where('customer_id', Auth::user()->id)->where('status', 0)->first();
        $Order_id = $Order->id;
        $Order->status = 1;
        $Order->update();

        $Order_details = OrderDetail::where('Order_id', $Order_id)->get();
        foreach ($Order_details as $Order_detail) {
            $product = product::where('id', $Order_detail->product_id)->first();
            $product->stok = $product->stok - $Order_detail->jumlah;
            $product->update();
        }



        // return redirect('history/' . $Order_id);
        return $this->sendResponse('Success', 'pesanan anda dikonpirmasi pak eko', $Order_id, 200);
    }
}
