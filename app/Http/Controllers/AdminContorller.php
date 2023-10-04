<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminContorller extends Controller
{
    public function index() {
        $products = Product::all();
        $myProducts = Product::query()->where('user_id', auth()->id())->get();
        $myOrders = Order::whereJsonContains('products', [['user_id' => auth()->id()]])->get();

        return view('pages.admin.index', compact('products', 'myProducts', 'myOrders'));
    }
}
