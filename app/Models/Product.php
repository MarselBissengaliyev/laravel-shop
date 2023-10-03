<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $filable = [
        'name', 'description', 'price', 'picture_url', 'user_id'
    ];

    public function Author() {
        return $this->belongsTo(User::class);
    }
}