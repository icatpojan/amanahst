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
use GuzzleHttp\Client;
use App\Jobs\ProductJob;
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
            'price' => 'required|string',
            'weight' => 'required|integer',
            'image' => 'image|mimes:png,jpeg,jpg',
            'stock' => 'required|integer'
        ]);
        if ($validator->fails()) {
            return response($validator->errors());
        }

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
        $product = Product::create([
            'name' => $request->name,
            'slug' => $request->name,
            'category_id' => $request->category_id,
            'customer_id' => $customer_id,
            'description' => $request->description,
            'image' => $image,
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
            'price' => 'required|string',
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
        $product = Product::find()->where('name', 'LIKE', '%' . $search . '%')->get();
        if (!$product) {

            return $this->sendResponse('Error', 'tidak ada data yang namanya kayak gitu', null, 500);
        }
        return response()->json([
            $product
        ]);
    }
    public function massUploadForm()
    {
        $category = Category::orderBy('name', 'DESC')->get();
        return view('products.bulk', compact('category'));
    }
    public function massUpload(Request $request)
    {
        //VALIDASI DATA YANG DIKIRIM
        $this->validate($request, [
            'category_id' => 'required|exists:categories,id',
            'file' => 'required|mimes:xlsx' //PASTIKAN FORMAT FILE YANG DITERIMA ADALAH XLSX
        ]);

        //JIKA FILE-NYA ADA
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '-product.' . $file->getClientOriginalExtension();
            $file->storeAs('public/uploads', $filename); //MAKA SIMPAN FILE TERSEBUT DI STORAGE/APP/PUBLIC/UPLOADS

            //BUAT JADWAL UNTUK PROSES FILE TERSEBUT DENGAN MENGGUNAKAN JOB
            //ADAPUN PADA DISPATCH KITA MENGIRIMKAN DUA PARAMETER SEBAGAI INFORMASI
            //YAKNI KATEGORI ID DAN NAMA FILENYA YANG SUDAH DISIMPAN
            ProductJob::dispatch($request->category_id, $filename);
            return redirect()->back()->with(['success' => 'Upload Produk Dijadwalkan']);
        }
    }
}
