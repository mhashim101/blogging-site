<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title','description','user_id','image','category_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
   
    public function comment()
    {
        return $this->hasMany(Comment::class);
    }

    public function like(){
        return $this->hasMany(Like::class);
    }

}

