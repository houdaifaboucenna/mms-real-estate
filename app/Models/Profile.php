<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'username',
        'picture',
        'bio',
        'image',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    #[Attribute]
    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->image ? asset('storage/images/profile/' . $this->image) : getGravatar($this->user->email),
        );
    }
}
