<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProducts extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'product_id'
    ];

    public function Product() {
        return $this->hasOne(Product::class);
    }
}
