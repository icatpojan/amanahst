<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use App\Product;
use Illuminate\Support\Str;
use File;
use Illuminate\Support\Facades\Validator;
use DB;

class ProductController extends Controller
{
    public function index()
    {
        $product = Product::with(['category'])->orderBy('created_at', 'DESC');

        if (request()->q != '') {
            $product = $product->where('name', 'LIKE', '%' . request()->q . '%');
        }
        $product = $product->paginate(10);
        return response()->json([
            $product
        ]);
    }
    public function create()
    {
        $category = Category::orderBy('name', 'DESC')->get();
        return view('products.create', compact('category'));
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'description' => 'required',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|integer',
            'weight' => 'required|integer',
            'image' => 'image|mimes:png,jpeg,jpg',
            'stock' => 'required|integer'
        ]);
        if ($validator->fails()) {
            return response($validator->errors());
        }
        $filename = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');

            $filename = time() . Str::slug($request->name) . '.' . $file->getClientOriginalExtension();
            // $file->storeAs('public/products', $filename);
            $request->image->move(public_path('product'), $filename);
        }
        $product = Product::create([
            'name' => $request->name,
            'slug' => $request->name,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'image' => $filename,
            'price' => $request->price,
            'weight' => $request->weight,
            'status' => $request->status,
            'stock' => $request->stock
        ]);
        try {
            $product->save();
            // $product = Product::all();

            return $this->sendResponse('Success', 'berhasil menambah data', $product, 200);
        } catch (\Throwable $th) {
            return $this->sendResponse('Error', 'Gagal menambah data', null, 500);
        }
    }
    public function destroy($id)
    {
        $product = Product::find($id);
        if ($product) {
            $product->delete();
            File::delete(public_path('product/' . $product->image));
            return $this->sendResponse('Success', 'Berhasil menghapus data', $product, 200);
        }
        return $this->sendResponse('Error', 'Gagal menghapus data', null, 500);
    }


    public function show($id)
    {
        $product = product::find($id);
        if (!$product) {

            return $this->sendResponse('Error', 'Gagal mengambil data', null, 500);
        }
        return $this->sendResponse('Success', 'Berhasil mengambil data', $product, 200);
    }
    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'description' => 'required',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|integer',
            'weight' => 'required|integer',
            'image' => 'image|mimes:png,jpeg,jpg',
            'stock' => 'required|integer'
        ]);
        if ($validator->fails()) {
            return response($validator->errors());
        }

        $product = Product::find($id);
        $filename = $product->image;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . Str::slug($request->name) . '.' . $file->getClientOriginalExtension();
            // $file->storeAs('public/products', $filename);
            $request->image->move(public_path('product'), $filename);
            File::delete(storage_path('product/' . $product->image));
        }

        //KEMUDIAN UPDATE PRODUK TERSEBUT
        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'weight' => $request->weight,
            'image' => $filename,
            'stock' => $request->stock
        ]);
        try {
            $product->save();
            // $product = Product::all();

            return $this->sendResponse('Success', 'berhasil mengganti data', $product, 200);
        } catch (\Throwable $th) {
            return $this->sendResponse('Error', 'Gagal mengganti data', null, 500);
        }
    }
    public function search(Request $request)
    {

        $search = $request->get('search');
        $product = DB::table('products')->where('name', 'LIKE', '%' . $search . '%')->paginate(10);
        if (!$product) {

            return $this->sendResponse('Error', 'tidak ada data yang namanya kayak gitu', null, 500);
        }
        return response()->json([
            $product
        ]);
    }
}
