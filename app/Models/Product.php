<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected  $fillable  = [
        'name', 'description', 'price', 'picture_url', 'user_id'
    ];

    public function author()
    {
        return $this->belongsTo(User::class);
    }
}
