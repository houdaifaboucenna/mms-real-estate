<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['name', 'email', 'post_id', 'content'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function getGravatar()
    {
        $hash = md5(strtolower(trim($this->attributes['email'])));

        return "http://gravatar.com/avatar/{$hash}";
    }
}
