<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $filable = [
        'number', 'status'
    ];

    public function OrderProducts() {
        return $this->hasMany(OrderProducts::class);
    }

    public function Author() {
        return $this->belongsTo(User::class);
    }
}