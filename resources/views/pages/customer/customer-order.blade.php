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
      <div id="orders">
        <h2>Order info</h2>
        <div id="orders-list" class="row">
            <div class="col-md-12 product-card">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Number order: {{ $order->number }}</h5>
                        <p class="card-text">Status: {{ $order->status }}</p>
                        <p class="card-text">Created at: {{ $order->created_at->format('d/m/Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr>

        <div id="products">
            <h2>Products of this order</h2>
            <div class="row">
                @foreach ($order->products as $product)
                    <div class="col-md-4 product-card">
                        <div class="card">
                            <img src="{{ $product['picture_url'] }}" class="card-img-top" alt="Product Image">
                            <div class="card-body">
                                <h5 class="card-title">{{ $product['name'] }}</h5>
                                <p class="card-text">{{ $product['description'] }}</p>
                                <p class="card-text">{{ $product['price'] }} ₸</p>
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
