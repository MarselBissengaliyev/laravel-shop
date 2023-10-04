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

        header,
        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 1em;
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
    <header>
        <h1>Registration</h1>
    </header>
    <main>
        <section>
            <h2>Registartion for admin</h2>
            <form action="{{ route('auth.signup') }}" method="POST" id="loginForm">
                @csrf
                <label for="username">Username:</label>
                <input type="text" id="user_name" name="user_name" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>

                <input type="hidden" id="role" name="role" value="admin" required>

                <button type="submit">Registration</button>
                <a class="registration-link" href="{{ route('admin.show.login') }}">Login</a>
            </form>

            @include('includes.errors')
        </section>
    </main>

    <footer>
        <p>&copy; 2023 Laravel Shop. All rights reserved.</p>
    </footer>
@endsection

@section('scripts')
@endsection
