<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Order;
use Illuminate\Support\Facades\Auth;
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
        DB::beginTransaction();
        try {
            $Order = Order::where('customer_id', Auth::user()->id)->where('status', '!=', 1)->get();
            if ($Order->jumlah_harga != $request->amount) {
                return $this->sendResponse('Error', 'duit anda kurang pak eko', null, 200);
            }
            if ($Order->status == 1 && $request->hasFile('bukti')) {
                $file = $request->file('bukti');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/payment', $filename);

                Payment::create([
                    'order_id' => $Order->id,
                    'name' => $request->name,
                    'transfer_to' => $request->transfer_to,
                    'transfer_date' => Carbon::parse($request->transfer_date)->format('Y-m-d'),
                    'amount' => $request->amount,
                    'bukti' => $filename,
                    'status' => null
                ]);
                $Order->update(['status' => 2]);
                DB::commit();
                return $this->sendResponse('succes', 'transfer dikonfirmasi', null, 200);
            }
            //REDIRECT DENGAN ERROR MESSAGE
        } catch (\Exception $e) {
            return $this->sendResponse('Error', 'sudah dikonfirmasi', null, 200);
            DB::rollback();
        }
    }
}
