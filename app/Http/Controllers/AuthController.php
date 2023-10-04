<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignInRequest;
use App\Http\Requests\SignUpRequest;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function ShowLogin()
    {
        if (auth()->user() && auth()->user()->role == "customer") {
            return redirect()->route('customer.index');
        }
        return view('index');
    }

    public function ShowRegistration()
    {
        if (auth()->user() && auth()->user()->role == "customer") {
            return redirect()->route('customer.index');
        }
        return view('pages.auth.register');
    }

    public function ShowAdminLogin()
    {
        if (auth()->user() && auth()->user()->role == "admin") {
            return redirect()->route('admin.index');
        }
        return view('pages.admin.auth.login');
    }

    public function ShowAdminRegistration()
    {
        return view('pages.admin.auth.register');
    }

    public function ShowCreateProduct() {
        return view('pages.admin.create-product');
    }

    public function ShowUpdateProduct(int $productId) {
        $product = Product::query()->where('id', $productId)->first();
        
        return view('pages.admin.update-product', compact('product'));
    }

    //
    public function SignUp(SignUpRequest $request)
    {
        $validated = $request->validated();

        $user = User::create([
            'user_name' => $validated['user_name'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        Auth::login($user);

        if ($user->role == 'admin') {
            return redirect()->route('admin.index');
        }

        return redirect()->route('customer.index');
    }

    public function SignIn(SignInRequest $request)
    {

        $validated = $request->validated();

        $user = User::query()->where('user_name', $validated['user_name'])->first();

        if ($user == null) {
            return redirect()->back()->withErrors(['msg' => 'user has not been found']);
        }

        $passwordIsValid = Hash::check($validated['password'], $user->password);
        if (!$passwordIsValid) {
            return redirect()->back()->withErrors(['msg' => 'password not valid']);
        }

        Auth::login($user);

        if ($user->role == 'admin') {
            return redirect()->route('admin.index');
        }

        return redirect()->route('customer.index');
    }

    public function Logout(Request $request)
    {
        Auth::logout();

        return redirect()->route('auth.show.login');
    }
}
