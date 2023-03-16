<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Follow;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Searchable;
class User extends Authenticatable

{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
   
    protected $fillable = [
        'fullname',
        'username',
        'email',
        'password',
    ];
    public function toSearchableArray(){
        return ['username' => $this->username,'fullname' => $this->fullname];
    }
    protected function avatar(): Attribute{
        return Attribute::make(get: function($value){
            return $value ? '/storage/avatars/' .$value : '/fallback-avatar.jpg';
        });
    }
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function posts() {

        return $this->hasMany(Post::class, 'user_id');
    }

    public function feedPosts(){
        //6 arguments
        //1s argument get post table to see the post the user that thier follow
        //2nd argument follow table to get the user that their follow
        //3rd argument foreign key in post table
        //4rth argument foreign key in follow table
        //5th reference in Users tables that is ID as primary key
        //6th argument is the followeduser in follow table to get the reletionship of the user that their follow
        return $this->hasManyThrough(Post::class,Follow::class,'user_id','user_id','id','followeduser');
    }
    public function followed() {

        return $this->hasMany(Follow::class, 'user_id');
    }
    public function followers() {

        return $this->hasMany(Follow::class, 'followeduser');
    }
}
