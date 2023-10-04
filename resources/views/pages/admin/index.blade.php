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
            <a href="{{ route('admin.create.product') }}" class="btn btn-primary mt-5 mb-5">CREATE NEW PRODUCT +</a>
            <div class="row">
                @foreach ($products as $product)
                    <div class="col-md-4 product-card">
                        <div class="card">
                            <img src="{{ $product->picture_url }}" class="card-img-top" alt="Product Image">
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text">{{ $product->description }}</p>
                                <p class="card-text">{{ $product->price }} ₸</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div id="my-products">
          <h2>My Product List</h2>
          <div class="row">
              @foreach ($myProducts as $product)
                  <div class="col-md-4 product-card">
                      <div class="card">
                          <img src="{{ $product->picture_url }}" class="card-img-top" alt="Product Image">
                          <div class="card-body">
                              <h5 class="card-title">{{ $product->name }}</h5>
                              <p class="card-text">{{ $product->description }}</p>
                              <p class="card-text">{{ $product->price }} ₸</p>
                          </div>
                          <a  class="btn btn-info m-1" href="{{ route('admin.update.product', ['product_id' => $product->id]) }}">Update</a>
                          <a class="btn btn-danger m-1" href="{{ route('products.delete', ['product_id' => $product->id]) }}">Delete</a>
                      </div>
                  </div>
              @endforeach
          </div>
      </div>

      

        <hr>

        <div id="orders">
            <h2>My Orders</h2>
            <div id="orders-list" class="row">
                @foreach ($myOrders as $order)
                    <div class="col-md-4 product-card">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Number order: {{ $order->number }}</h5>
                                <p class="card-text">Status: {{ $order->status }}</p>
                                <p class="card-text">Created at: {{ $order->created_at->format('d/m/Y   ') }}</p>
                                <a href="{{ route('customer.order', ['order_id' => $order->id]) }}">More info</a>
                                <br>
                                    <button data-value="accepted" data-order-id="{{ $order->id }}" class="btn-status btn btn-primary"href="#">Accept order</button>
                                    <button data-value="rejected" data-order-id="{{ $order->id }}" class="btn-status btn btn-danger"href="#">Reject order</button>
                                    <button data-value="in_progress" data-order-id="{{ $order->id }}" class="btn-status btn btn-outline-dark"href="#">In progress</button>
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
    <script src="{{ asset('admin.js') }}"></script>
@endsection
