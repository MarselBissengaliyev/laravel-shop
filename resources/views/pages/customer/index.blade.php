@extends('layouts.layout')

@section('styles')
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        main {
            padding: 30px;
        }

        .product-card {
            margin-bottom: 20px;
        }

        .cart-item {
            list-style: none;
            padding: 10px;
            border: 1px solid #ddd;
            margin-bottom: 10px;
        }

        .order-item {
            list-style: none;
            padding: 10px;
            border: 1px solid #ddd;
            margin-bottom: 10px;
        }
    </style>
@endsection

@section('content')
@include('includes.header')
    <main class="container">
        <div id="products">
            <h2>Product List</h2>
            <div class="row">
                @foreach ($products as $product)
                    <div class="col-md-4 product-card">
                        <div class="card">
                            <img src="{{ $product->picture_url }}" class="card-img-top" alt="Product Image">
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text">{{ $product->description }}</p>
                                <p class="card-text">{{ $product->price }} ₸</p>
                                <button class="add-to-cart btn btn-primary" data-product="{{ $product }}">Add to
                                    Cart</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <hr>

        <div id="cart">
            <h2>Shopping Cart</h2>
            <div id="cart-list" class="row">
                <!-- Cart items will be added here dynamically -->
            </div>
            <button class="btn btn-success" id="checkout">Checkout</button>
            <button class="btn btn-success" id="buy">Buy</button>
        </div>

        <hr>

        <div id="orders">
            <h2>My Orders</h2>
            <div id="orders-list" class="row">
                @foreach ($orders as $order)
                    <div class="col-md-4 product-card">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Number order: {{ $order->number }}</h5>
                                <p class="card-text">Status: {{ $order->status }}</p>
                                <p class="card-text">Created at: {{ $order->created_at->format('d/m/Y   ') }}</p>
                                <a href="{{ route('customer.order', ['order_id' => $order->id]) }}">More info</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </main>

    <footer class="container">
        <p>&copy; 2023 Laravel Shop. All rights reserved.</p>
    </footer>
@endsection

@section('scripts')
    <script src="{{ asset('customer.js') }}"></script>
@endsection
