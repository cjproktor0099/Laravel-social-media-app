<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Post extends Model
{
    use Searchable;
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['title','body','user_id','image_post'];
public function toSearchableArray(){
    return ['title' => $this->title,'body' => $this->body];
}


    public function user() {
       
        return $this->belongsTo(User::class, 'user_id');
    }
}
