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
    public function trash()
    {
        // mengampil data guru yang sudah dihapus
        $User = User::onlyTrashed()->get();
        return view('pembeli.trash', compact('User'));
    }
    // restore data guru yang dihapus
    public function kembalikan($id)
    {
        $User = User::onlyTrashed()->where('id', $id);
        $User->restore();
        // return redirect('/guru/trash');
    }
    public function hapus_permanen($id)
    {
        // hapus permanen data guru
        $User = User::onlyTrashed()->where('id', $id);
        $User->forceDelete();
    }   
}
