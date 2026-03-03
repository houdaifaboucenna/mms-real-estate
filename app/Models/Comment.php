<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    protected $fillable = ['name', 'email', 'post_id', 'content'];

    protected $appends = ['gravatar'];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function gravatar(): Attribute
    {
        return Attribute::make(
            get: fn () => getGravatar($this->email),
        );
    }
}
