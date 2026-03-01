<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnitUsaha extends Model
{
    protected $fillable = ['name', 'description', 'price', 'image', 'status', 'contact_number', 'instagram_url', 'show_price'];
}
