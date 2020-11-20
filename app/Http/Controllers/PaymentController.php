<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Order;
use App\OrderDetail;
use Auth;
use App\Payment;
use Carbon\Carbon;
use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Client;

class PaymentController extends Controller
{
    public function paymentForm()
    {
        return $this->sendResponse('succes', 'silakan isi form pembayaran', null, 200);
    }

    public function storePayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'transfer_to' => 'required|string',
            'transfer_date' => 'required',
            'amount' => 'required|integer',
            'bukti' => 'required|image|mimes:jpg,png,jpeg'
        ]);
        if ($validator->fails()) {
            return response($validator->errors());
        }
        
        $order = Order::where('customer_id', Auth::user()->id)->where('status', '=', 1)->first();
        if (!$order) {
            return response('tidak ada tagihan');
        }
        if ($order->jumlah_harga > $request->amount) {
            return response('nominal yang anda massukan kurang');
        }
       $image = null;

        if ($request->image) {
            // $image = $request->image->getClientOriginalName() . '-' . time() . '.' . $request->image->extension();
            // $request->image->move(public_path('img'), $image);

            $img = base64_encode(file_get_contents($request->image));
            $client = new Client();
            $res = $client->Request('POST', 'https://freeimage.host/api/1/upload', [
                'form_params' => [
                    'key' => '6d207e02198a847aa98d0a2a901485a5',
                    'action' => 'upload',
                    'source' => $img,
                    'format' => 'json',
                ]
            ]);
            $array = json_decode($res->getBody()->getContents());
            
            $image = $array->image->file->resource->chain->image;
        }
        $customer_id = Auth::id();
        Payment::create([
            'order_id' => $order->id,
            'name' => $request->name,
            'transfer_to' => $request->transfer_to,
            'transfer_date' => Carbon::parse($request->transfer_date)->format('Y-m-d'),
            'amount' => $request->amount,
            'bukti' => $image,
        ]);
        $order->status = 2;
        $order->update();
        try {
            $order->save();
            // $product = Product::all();

            return $this->sendResponse('Success', 'konfirmasi transferberhasil', $product, 200);
        } catch (\Throwable $th) {
            return $this->sendResponse('Error', 'Gagal menambah data', null, 500);
        }
    }
    public function gasorder()
    {
        
        $Order_details = [];
        $Order = OrderDetail::where('product_id', Auth::user()->id)->where('status', 0)->first();
        if (!empty($Order)) {
            $Order_details = OrderDetail::where('order_id', $Order->id)->get();
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
}
