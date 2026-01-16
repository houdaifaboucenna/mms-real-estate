<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;

    protected $fillable = ['home_imgs','facebook','instagram','twitter','youtube','whatsapp','telegram','phone','email','desc','desc_ar','keywords','keywords_ar'];

}
