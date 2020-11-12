<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Shop;
class ShopController extends Controller
{
    public function index()
    {
    
    }
    public function create()
    {
    
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'image' =>  'mimes:jpeg,png,jpg,gif,svg'

        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
           
            $filename = time() . Str::slug($request->name) . '.' . $file->getClientOriginalExtension();
           
            $file->storeAs('public/shops', $filename);
    
          
            $shop = shop::create([
                'name' => $request->name,
                'slug' => $request->name,
                'category_id' => $request->category_id,
                'description' => $request->description,
                'image' => $filename, //PASTIKAN MENGGUNAKAN VARIABLE FILENAM YANG HANYA BERISI NAMA FILE SAJA (STRING)
                'price' => $request->price,
                'weight' => $request->weight,
                'status' => $request->status
            ]);
            //JIKA SUDAH MAKA REDIRECT KE LIST PRODUK
            return redirect(route('shop.index'))->with(['success' => 'Produk Baru Ditambahkan']);
        }
    }
}
