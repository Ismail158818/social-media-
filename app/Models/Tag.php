<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    protected $fillable = ['tag_name','user_id','group_id'];

    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }


}
