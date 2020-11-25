<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Http\Resources\OrderDetailResource;
use Illuminate\Http\Request;
use DB;
use App\Order;
use App\OrderDetail;
use Auth;
use App\Payment;
use App\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Client;


class PaymentController extends Controller
{
    public function __construct()
    {
        $order_detail = OrderDetail::all();
        $order = Order::all();
        if ($order_detail->status = 1) {
        }
    }
    public function paymentForm()
    {


        $Order_details = [];
        $Order = Order::where('customer_id', Auth::user()->id)->where('status', 1)->first();
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

    public function storePayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string',
            'transfer_to' => 'string',
            'transfer_date' => 'date',
            'amount' => 'integer',
            'bukti' => 'required|image|mimes:jpg,png,jpeg'
        ]);
        if ($validator->fails()) {
            return response($validator->errors());
        }

        $order = Order::where('customer_id', Auth::user()->id)->where('status', '=', 1)->first();
        if (!$order) {
            return $this->sendResponse('error', 'tidak ada tagihan', null, 500);
        }
        if ($order->jumlah_harga > $request->amount) {
            return $this->sendResponse('error', 'nominal kurang', null, 500);
        }
        
        $image = null;
        if ($request->bukti) {
            // $image = $request->image->getClientOriginalName() . '-' . time() . '.' . $request->image->extension();
            // $request->image->move(public_path('img'), $image);

            $img = base64_encode(file_get_contents($request->bukti));
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
        $payment = Payment::create([
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
            return $this->sendResponse('Success', 'konfirmasi transfer berhasil', $order , 200);
        } catch (\Throwable $th) {
            return $this->sendResponse('Error', 'Gagal menambah data', null, 500);
        }
    }
    public function gasOrder()
    {
        $id = Auth::user()->id;
        $Order_details = [];
        //all dan with tidak bisa digabungkan ferguso
        // $order= Order::where('status' , 1)->first();
        // $product =Product::where('customer_id', Auth::user()->id)->get();
        // $Order_detail= OrderDetail::where('product_id', $product->id)->where('order_id', $order->id)->first();
        // $Order = OrderDetail::with(['product'])->where('customer_id', Auth::user()->id)->where('Customer_id', )->get();
        $Order = OrderDetail::with(['product:id,name,customer_id,image', 'order:id,status,customer_id'])->whereHas('product', function ($q) use ($id) {
            return $q->where('customer_id', $id);
        })

            ->get();
        $Order_details = $Order->where('product.customer_id', $id)->where('order.status', 2);
        return $this->sendResponse('success', 'daftar pemesan barang', $Order_details, 200);

        // $Order_details = Order::where('customer_id', Auth::user()->id)
        //                 ->
        // ->get();


        $Order_detail = OrderDetailResource::collection(OrderDetail::all());
        //   $Order_details= $Order_detail->where('customer_id', Auth::user()->id)->first();
        // $id = Auth::user()->id;
        // $Order_detail = collect(json_decode(json_encode($Order_detail)));

        var_dump($Order_detail);
        die;
        $Order_details = $Order_detail->where('customer_id', $id)->where('status', 1);
        // $Order_detail = $Order_detail->values()->all();
        if ($Order_details->isEmpty()) {
            return $this->sendResponse('error', 'gak ada apa apa', null, 400);
        }


        return $this->sendResponse('success', 'ini dia daftar pemesan anda', $Order_details, 200);
    }
    public function show($id)
    {
        $payment = Payment::where('order_id', $id)->get();
        if ($payment->isEmpty()) {

            return $this->sendResponse('Error', 'belom dibayar pak eko', null, 500);
        }
        return $this->sendResponse('Success', 'Berhasil mengambil data pembayaran pak eko', $payment, 200);
    }
    public function send($id)
    {
        $order_detail = OrderDetail::find($id);
        $order_detail->status = 2;
        $order_detail->update();
        return $this->sendResponse('Success', 'barang sudah anda kirim', null, 200);
    }
}
