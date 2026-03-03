<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    protected $fillable = [
        'question',
        'answer',
        'question_ar',
        'answer_ar',
        'show_home',
    ];

    protected function casts(): array
    {
        return [
            'show_home' => 'boolean',
        ];
    }
}
