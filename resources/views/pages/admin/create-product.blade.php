@extends('layouts.layout')

@section('styles')
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
        }

        main {
            padding: 20px;
            min-height: 80vh;
            margin-top: 100px;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            margin: 0 auto;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        form a {
            font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;
            margin-left: 30px;
        }
    </style>
@endsection


@section('content')
@include('includes.header')
    <main>
        <section>

            <h2>CREATE PRODUCT</h2>
            <form action="{{ route('products.create') }}" method="POST" id="loginForm">
                @csrf
                <label for="name">Product name:</label>
                <input type="text" id="name" name="name" required>

                <label for="description">Description:</label>
                <input type="text" id="description" name="description" required>

                <label for="price">Price:</label>
                <input type="number" step="0.01" id="price" name="price" required>

                <label for="picture_url">Pciture URL:</label>
                <input type="text" step="0.01" id="picture_url" name="picture_url" required>

                <button type="submit">Create product</button>
            </form>

        </section>
    </main>

    <footer>
        <p>&copy; 2023 Laravel Shop. All rights reserved.</p>
    </footer>
@endsection

@section('scripts')
@endsection
