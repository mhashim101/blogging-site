<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory;
    protected $fillable = ['body','user_id','comment_id','reply_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function comment(){
        return $this->belongsTo(Comment::class);
    }

    public function parentReply(){
        return $this->belongsTo(Reply::class, 'reply_id');
    }
    public function replies_m(){
        return $this->hasMany(Reply::class, 'reply_id');
    }

}
