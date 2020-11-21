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
use Illuminate\Support\Facades\Validator;


class OrderController extends Controller
{

    public function index($id)
    {
        $product = product::find($id);
        if (!$product) {

            return $this->sendResponse('Error', 'Gagal mencoba memesan', null, 500);
        }
        return $this->sendResponse('Success', 'anda mencoba memesan', $product, 200);
    }

    public function order(Request $request, $id)
    {
        $product = product::where('id', $id)->first();
        $tanggal = Carbon::now();
        //cek dulu ada barang dengan id sekian gakk??
        if (!$product) {
            return $this->sendResponse('error', 'barang habis/tidak ada', null, 500);
        }
        //validasi apakah melebihi stok
        if ($request->jumlah_pesan > $product->stock) {
            return $this->sendResponse('error', 'stok terbatas', null, 500);
        }

        //cek validasi
        $cek_Order = Order::where('customer_id', Auth::user()->id)->where('status', 0)->first();
        //simpan ke database Order
        if (empty($cek_Order)) {
            $Order = new Order;
            $Order->customer_id = Auth::user()->id;
            $Order->tanggal = $tanggal;
            $Order->status = 0;
            $Order->jumlah_harga = 0;
            // $Order->kode = mt_rand(100, 999);
            $Order->save();
        }


        //simpan ke database Order detail
        $Order_baru = Order::where('customer_id', Auth::user()->id)->where('status', 0)->first();

        //cek Order detail
        $cek_Order_detail = OrderDetail::where('product_id', $product->id)->where('order_id', $Order_baru->id)->first();
        if (empty($cek_Order_detail)) {
            $Order_detail = new OrderDetail;
            $Order_detail->product_id = $product->id;
            $Order_detail->order_id = $Order_baru->id;
            $Order_detail->jumlah = $request->jumlah_pesan;
            $Order_detail->jumlah_harga = $product->price * $request->jumlah_pesan;
            $Order_detail->save();
        } else {
            $Order_detail = OrderDetail::where('product_id', $product->id)->where('order_id', $Order_baru->id)->first();

            $Order_detail->jumlah = $Order_detail->jumlah + $request->jumlah_pesan;

            //harga sekarang
            $harga_Order_detail_baru = $product->price * $request->jumlah_pesan;
            $Order_detail->jumlah_harga = $Order_detail->jumlah_harga + $harga_Order_detail_baru;
            $Order_detail->update();
        }

        //jumlah total
        $Order = Order::where('customer_id', Auth::user()->id)->where('status', 0)->first();
        $Order->jumlah_harga = $Order->jumlah_harga + $product->price * $request->jumlah_pesan;
        $Order->update();

        return $this->sendResponse('Success', 'pesanan anda masuk keranjang pak eko', $product, 200);
    }

    public function check_out()
    {
        
        $Order_details = [];
        $Order = Order::where('customer_id', Auth::user()->id)->where('status', 0)->first();
        if (!empty($Order)) {
            $Order_details = OrderDetail::where('order_id', $Order->id)->with(['product'])->get();
        }
        if (empty($Order)) {
            return $this->sendResponse('error', 'keranjang kosong', null, 500);
        }
        // return view('pesan.check_out', compact('Order', 'Order_details'));
        // return $this->sendResponse('Success', 'ini dia pesanan anda pak eko',$Order, 200);
        return $this->sendResponse('Success', 'ini dia pesanan anda pak eko', $Order_details, 200);
        // return response()->json([
        //     $Order_details

        // ]);
    }

    public function delete($id)
    {
        $Order_detail = OrderDetail::where('id', $id)->first();
        if (!$Order_detail) {
            return $this->sendResponse('error', 'data tidak ada', null, 200);
        }
        $Order = Order::where('id', $Order_detail->order_id)->first();
        $Order->jumlah_harga = $Order->jumlah_harga - $Order_detail->jumlah_harga;
        $Order->update();


        $Order_detail->delete();

        return $this->sendResponse('Success', 'pesanan anda dihapus', null, 200);
    }
    

    public function konfirmasi(Request $request)
    {
        $user = User::where('id', Auth::user()->id)->first();
        // if (empty($user->alamat)) {
        //     return $this->sendResponse('error', 'isi alamat dulu pak eko', null, 200);
        //     return redirect('profile');
        // }

        // if (empty($user->nomor_telpon)) {
        //     return $this->sendResponse('error', 'isi identitas dulu pak eko', null, 200);
        //     return redirect('profile');
        // }
        $Order = Order::where('customer_id', Auth::user()->id)->where('status', 0)->first();
       
        if (!$Order) {
            return $this->sendResponse('error', 'tidak ada pesanan', null, 200);
        }
        $validator = Validator::make($request->all(), [
            'tujuan' => 'required|string|max:100',
        ]);
        if ($validator->fails()) {
            return response($validator->errors());
        }
        $Order->tujuan = $request->tujuan;
        $Order->status = 1;
        $Order->update();
        

        // $Order_id = $Order->id;
        $Order_details = OrderDetail::where('Order_id', $Order->id)->get();
        foreach ($Order_details as $Order_detail) {
            $product = product::where('id', $Order_detail->product_id)->first();
            $product->stock = $product->stock - $Order_detail->jumlah;
            $product->update();
        }
        // return redirect('history/' . $Order_id);
        return $this->sendResponse('Success', 'pesanan anda dikonpirmasi pak eko', $Order, 200);
    }
}
