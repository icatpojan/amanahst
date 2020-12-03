<?php

namespace App\Http\Controllers;

use Auth;
use App\Category;
use App\komentar;
use Illuminate\Http\Request;
use App\Product;
use App\Shop;
use App\User;
use Illuminate\Support\Str;
use File;
use Illuminate\Support\Facades\Validator;
use DB;
use GuzzleHttp\Client;

class ShopController extends Controller
{
    public function index()
    {
        $shop = Shop::all();
        return $this->sendResponse('Success', 'semua toko ada disini', $shop, 200);
    }
    public function search(Request $request)
    {

        $search = $request->get('search');
        $shop = Shop::with(['user'])->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($search) . '%'])->orWhereRaw('LOWER(description) LIKE ?', ['%' . strtolower($search) . '%'])->get();
        if (($shop)->isEmpty()) {

            return $this->sendResponse('Error', 'tidak ada toko yang namanya kayak gitu', null, 500);
        }
        return $this->sendResponse('Error', 'this is man', $shop, 200);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'description' => 'required',
            'image' => 'image|mimes:png,jpeg,jpg',
            'alamat' => 'required|string|max:100',
        ]);
        if ($validator->fails()) {
            return response($validator->errors());
        }
        $image = null;

        if ($request->image) {
            // $image = $request->image->getClientOriginalName() . '-' . time() . '.' . $request->image->extension();
            // $request->image->move(public_path('img'), $image);

            $img = base64_encode(file_get_contents($request->image));
            $client = new Client();
            $res = $client->request('POST', 'https://freeimage.host/api/1/upload', [
                'form_params' => [
                    'key' => '6d207e02198a847aa98d0a2a901485a5',
                    'action' => 'upload',
                    'source' => $img,
                    'format' => 'json',
                ]
            ]);
            $array = json_decode($res->getBody()->getContents());
            // dd($array);
            $image = $array->image->file->resource->chain->image;
        }
        $customer_id = Auth::id();
        $user = User::where('id',$customer_id)->get();
        $user->role = 2;
        $shop = Shop::create([
            'name' => $request->name,
            'customer_id' => $customer_id,
            'description' => $request->description,
            'image' => $image,
            'alamat' => $request->alamat
        ]);
        try {
            $shop->save();
            // $user->save();
            // $product = Product::all();

            return $this->sendResponse('Success', 'berhasil menjual barang ilegal', $shop, 200);
        } catch (\Throwable $th) {
            return $this->sendResponse('Error', 'Gagal menjual data pemerintah', null, 500);
        }
    }
    public function show($id)
    {
        $shop = Shop::with(['user'])->find($id);
        if (!$shop) {

            return $this->sendResponse('Error', 'Gagal mengambil data', null, 500);
        }
        return $this->sendResponse('Success', 'Berhasil mengambil data', $shop, 200);
    }
    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'description' => 'required',
            'image' => 'image|mimes:png,jpeg,jpg',
            'alamat' => 'required|string|max:100',
        ]);
        if ($validator->fails()) {
            return response($validator->errors());
        }

        $shop = Shop::find($id);
        $image = null;

        if ($request->image) {
            // $image = $request->image->getClientOriginalName() . '-' . time() . '.' . $request->image->extension();
            // $request->image->move(public_path('img'), $image);

            $img = base64_encode(file_get_contents($request->image));
            $client = new Client();
            $res = $client->request('POST', 'https://freeimage.host/api/1/upload', [
                'form_params' => [
                    'key' => '6d207e02198a847aa98d0a2a901485a5',
                    'action' => 'upload',
                    'source' => $img,
                    'format' => 'json',
                ]
            ]);
            $array = json_decode($res->getBody()->getContents());
            // dd($array);
            $image = $array->image->file->resource->chain->image;
        }

        //KEMUDIAN UPDATE PRODUK TERSEBUT
        $shop->update([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $image,
            'alamat' => $request->alamat
        ]);
        try {
            $shop->save();
            // $product = Product::all();

            return $this->sendResponse('Success', 'berhasil mengganti data toko', $shop, 200);
        } catch (\Throwable $th) {
            return $this->sendResponse('Error', 'Gagal mengganti data', null, 500);
        }
    }
}
