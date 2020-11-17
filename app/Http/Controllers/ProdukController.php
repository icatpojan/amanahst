<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Category;
use Illuminate\Http\Request;
use App\Product;
use Illuminate\Support\Str;
use File;
use Illuminate\Support\Facades\Validator;
use DB;

class ProdukController extends Controller
{
    public function index()
    {
        $Products = Product::paginate(20);
        return view('products.index', compact('Products'));
        
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
        $customer_id= Auth::id(); 
        $product = Product::create([
            'name' => $request->name,
            'slug' => $request->name,
            'category_id' => $request->category_id,
            'customer_id' =>$customer_id,
            'description' => $request->description,
            'image' => $filename,
            'price' => $request->price,
            'weight' => $request->weight,
            'status' => $request->status,
            'stock' => $request->stock
        ]);
        return redirect(route('produk.index'))->with(['success' => 'Produk Baru Ditambahkan']);
    
    }
    public function destroy($id)
    {
        $product = Product::find($id);
        if ($product) {
            $product->delete();
            File::delete(public_path('product/' . $product->image));
            return $this->sendResponse('Success', 'Berhasil menghapus data', $product, 200);
        }
        return redirect(route('produk.index'))->with(['success' => 'Produk Sudah Dihapus']);
    } 

    public function show($id)
    {
        $product = product::find($id);
        if (!$product) {

            return $this->sendResponse('Error', 'Gagal mengambil data', null, 500);
        }
        return $this->sendResponse('Success', 'Berhasil mengambil data', $product, 200);
    }
    public function edit($id)
    {
        $product = Product::find($id); //AMBIL DATA PRODUK TERKAIT BERDASARKAN ID
        $category = Category::orderBy('name', 'DESC')->get(); //AMBIL SEMUA DATA KATEGORI
        return view('products.edit', compact('product', 'category')); //LOAD VIEW DAN PASSING DATANYA KE VIEW
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
        return redirect(route('produk.index'))->with(['success' => 'Data Produk Diperbaharui']);
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
