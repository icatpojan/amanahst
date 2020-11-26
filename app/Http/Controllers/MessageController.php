<?php

namespace App\Http\Controllers;

use App\Message;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Pusher\Pusher;

class MessageController extends Controller
{

    public function index()
    {
        // select all users except logged in user
        // $users = User::where('id', '!=', Auth::id())->get();

        // count how many message are unread from the selected user
        $users = DB::select("select users.id, users.name, users.avatar, users.email, count(is_read) as unread 
        from users LEFT  JOIN  messages ON users.id = messages.from and is_read = 0 and messages.to = " . Auth::id() . "
        where users.id != " . Auth::id() . " 
        group by users.id, users.name, users.avatar, users.email");

        // return view('home', ['users' => $users]);
        return response()->json([
            $users
        ]);
    }

    public function getMessage($user_id)
    {
        $my_id = Auth::id();

        // update status terbaca dari user yang mengirim pesan
        Message::where(['from' => $user_id, 'to' => $my_id])->update(['is_read' => 1]);

        // ambil pesanya dari user yang di select
        $messages = Message::where(function ($query) use ($user_id, $my_id) {
            $query->where('from', $user_id)->where('to', $my_id);
        })->oRwhere(function ($query) use ($user_id, $my_id) {
            $query->where('from', $my_id)->where('to', $user_id);
        })->get();

        // return view('messages.index', ['messages' => $messages]);
        return response()->json([
            $messages
        ]);
    }

    public function sendMessage(Request $request)
    {
        //fromnya dari id yang lagi login
        // to nya sesuai dengan request
        $from = Auth::id();
        $to = $request->receiver_id;
        $message = $request->message;

        $data = new Message();
        $data->from = $from;
        $data->to = $to;
        $data->message = $message;
        $data->is_read = 0; 
        // statusnya bakalan jadi 1 kalo diget ama penerima pesan
        $data->save();

        // pusher
        $options = array(
            'cluster' => 'ap2',
            'useTLS' => true
        );

        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );

        $data = ['from' => $from, 'to' => $to]; 
        // tersending saat dipencet enter
        $pusher->trigger('my-channel', 'my-event', $data);
    }
}