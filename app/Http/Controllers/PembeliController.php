<?php

namespace App\Http\Controllers;

use App\OrderDetail;
use App\Product;
use App\Shop;
use App\User;
use Illuminate\Http\Request;
use File;

class PembeliController extends Controller
{
    public function index()
    {
        $User = User::all();
        $Order_details = [];
        return view('pembeli.index', compact('User'));
    }
    public function show($id)
    {
        $user = User::where('id', $id);
        if ($user) {
            $user->delete();
            // File::delete(public_path('product/' . $product->image));
            return $this->index()->with(['success' => 'admin dihapus']);
        }
        return $this->sendResponse('Error', 'Gagal menghapus data', null, 500);
    }
    public function trash()
    {
        // mengampil data guru yang sudah dihapus
        $User = User::onlyTrashed()->get();
        return view('pembeli.trash', compact('User'));
    }
    // restore data guru yang dihapus
    public function restore($id)
    {
        $User = User::onlyTrashed()->where('id', $id);
        $User->restore();
        return $this->trash()->with(['success' => 'admin dikembalikan']);
    }
    public function hapus_permanen($id)
    {
        // hapus permanen data guru
        $User = User::onlyTrashed()->where('id', $id);
        $User->forceDelete();
        return $this->trash()->with(['success' => 'admin dikembalikan']);
    }   
    public function pendapatan($id)
    {
        $shop = Shop::where('customer_id', $id)->get();
        $product = null;
        $order = null;
        $Product = Product::where('shop_id', Auth::id())->count();
        $Order_details = [];
        $Order = OrderDetail::with(['product:id,name,customer_id,image', 'order:id,status,customer_id'])->whereHas('product', function ($q) use ($id) {
            return $q->where('customer_id', $id);
        })->get()->toArray();
        $Order_details = collect($Order)->where('product.customer_id', $id)->where('order.status', 2);
        $Order_details = $Order_details->values()->sum('jumlah_harga');
        return $this->index(compact('shop', 'Product', 'Order_details'));        
    }
}
