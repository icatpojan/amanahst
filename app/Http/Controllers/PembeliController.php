<?php

namespace App\Http\Controllers;

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
    

}
