<?php

namespace App\Http\Controllers;
// use Illuminate\Support\Facades\Auth;
use Auth;
use App\Category;
use Illuminate\Http\Request;
use App\Product;
use Illuminate\Support\Str;
use File;
use Illuminate\Support\Facades\Validator;
use DB;
use GuzzleHttp\Client;

class ProductController extends Controller
{
    public function category()
    {
        $category = Category::with(['parent'])->orderBy('created_at', 'DESC')->paginate(10);
        $parent = Category::getParent()->orderBy('name', 'ASC')->get();
        // return $this->sendResponse('Error', 'Gagal menghapus data', null, 500);
        return $this->sendResponse('succes', 'ini dia data category', $parent, 500);
    }
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
    public function ambilah()
    {
        $product = Product::where('customer_id', Auth::user()->id)->first();
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
            'price' => 'required|string',
            'weight' => 'required|integer',
            'image' => 'image|mimes:png,jpeg,jpg',
            'stock' => 'required|integer'
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
        $customer_id= Auth::id(); 
        $product = Product::create([
            'name' => $request->name,
            'slug' => $request->name,
            'category_id' => $request->category_id,
            'customer_id' =>$customer_id,
            'description' => $request->description,
            'image' => $image,
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
            'price' => 'required|string',
            'weight' => 'required|integer',
            'image' => 'image|mimes:png,jpeg,jpg',
            'stock' => 'required|integer'
        ]);
        if ($validator->fails()) {
            return response($validator->errors());
        }

        $product = Product::find($id);
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
        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'weight' => $request->weight,
            'image' => $image,
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
