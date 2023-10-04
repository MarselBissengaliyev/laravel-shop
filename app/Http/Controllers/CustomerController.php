<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function index() {
        $products = Product::all();
        $orders = Order::query()->where('user_id', auth()->id())->get();

        return view('pages.customer.index', compact('products', 'orders'));
    }

    public function getOrderPage(int $orderId) {
        $order = Order::query()->where('id',$orderId)->first();

        return view('pages.customer.customer-order', compact('order'));
    }
}
