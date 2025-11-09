<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'platform',
        'content',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
