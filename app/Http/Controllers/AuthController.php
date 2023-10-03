<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    //
    public function SignUp(Request $request) {
        dd($request->all());
    }

    public function SignIn(Request $request) {

    }

    public function Logout(Request $request) {

    }
}
