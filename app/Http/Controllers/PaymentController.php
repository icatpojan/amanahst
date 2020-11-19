<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Order;
use Auth;
use App\Payment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

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
        if ($order->jumlah_harga > $request->amount) {
            return response('nominal yang anda massukan kurang');
        }
        if ($order->status == 0 && $request->hasFile('bukti')) {
            $file = $request->file('image');

            $filename= time() . Str::slug($request->name) . '.' . $file->getClientOriginalExtension();
            // $file->storeAs('public/products', $filename);
            $request->image->move(public_path('product'), $filename);
        }
        $customer_id = Auth::id();
        Payment::create([
            'order_id' => $order->id,
            'name' => $request->name,
            'transfer_to' => $request->transfer_to,
            'transfer_date' => Carbon::parse($request->transfer_date)->format('Y-m-d'),
            'amount' => $request->amount,
            'bukti' => $filename,
            'status' => null
        ]);
        $order->update(['status' => 2]);
        try {
            $order->save();
            // $product = Product::all();

            return $this->sendResponse('Success', 'konfirmasi transferberhasil', $product, 200);
        } catch (\Throwable $th) {
            return $this->sendResponse('Error', 'Gagal menambah data', null, 500);
        }
    }
}
