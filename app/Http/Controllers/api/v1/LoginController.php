<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login( Request $request) {
        $login = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        if( !Auth::attempt( $login ) ) {
            return response(['message' => 'Invalid login credentials.']);
        }

        $accessToken = Auth::user()->createToken('authToken')->accessToken;

        return response(['user' => Auth::user(), 'access_token' => $accessToken]);
    }

    public function register(Request $request) {
        $register = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);

        $user = User::create($input);

        $responseArray = [];
        $responseArray['access_token'] = $user->createToken('authToken')->accessToken;
        $responseArray['user'] = $user;

        return response()->json($responseArray, 200);
    }

    public function logout() {
        auth()->user()->tokens->each(function ($token, $key) {
            $token->delete();
        });

        return response(['message' => 'Logged out successfully']);
    }
}
