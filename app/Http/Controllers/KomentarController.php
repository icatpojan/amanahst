<?php

namespace App\Http\Controllers;

use App\Komentar;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KomentarController extends Controller
{
    public function komentar(Request $request, $id)
    {
        $Product_id = Product::find($id);
        $validator = Validator::make($request->all(), [
            'komentar' => 'string|max:100',
        ]);
        if ($validator->fails()) {
            return response($validator->errors());
        }
        $customer_id = Auth::id();
        $komentar = Komentar::create([
            'komentar' => $request->komentar,
            'product_id' => $Product_id,
            'customer_id' => $customer_id
        ]);
        try {
            $komentar->save();
            return $this->sendResponse('Success', 'berhasil membuat komentar', $komentar, 200);
        } catch (\Throwable $th) {
            return $this->sendResponse('Error', 'Gagal  membuat komentar', null, 500);
        }
    }
}
