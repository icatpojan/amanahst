<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['from', 'to', 'message', 'is_read'];
    public function user()
    {
        return $this->belongsTo('App\User','from', 'id');
    }
    public function pengguna()
    {
        return $this->belongsTo('App\User','to', 'id');
    }

    public function broadcastOn()
    {
        return ['my-channel'];
    }
  
    public function broadcastAs()
    {
        return 'my-event';
    }
}
