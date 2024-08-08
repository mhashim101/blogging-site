<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable 
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public function post()
    {
        return $this->hasMany(Post::class);
    }
    public function emailverificationtoken()
    {
        return $this->hasMany(EmailVerificationToken::class);
    }

    public function like(){
        return $this->hasMany(Like::class);
    }
 
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile',
        'google_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Users whom this user is following
    // public function following():BelongsToMany
    // {
    //     return $this->belongsToMany(User::class, 'follows', 'follower_id', 'followee_id');
    // }


    public function followers():BelongsToMany
    {
        return $this->belongsToMany(User::class, 'follows', 'followee_id', 'follower_id');
    }


    // Check if the user is following another user
    public function isFollowing($user)
    {   
        if(Auth::check()){
            return $this->followers->contains($user->id);
        }
    }
}
