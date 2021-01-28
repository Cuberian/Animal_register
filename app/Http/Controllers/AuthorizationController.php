<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthorizationController extends Controller
{
    function login() {
        return view('auth.login');
    }
    function register() {
        return view('auth.register');
    }
}
