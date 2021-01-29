<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function login( Request $request) {
        $login = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $request->email)->first();

        if( !$user || !Hash::check($request->password, $user->password) ) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect']
            ]);
        }

        return  $user->createToken('authToken')->accessToken;
    }

    public function register(Request $request) {
        $request->validate([
            'name' => 'required',
            'role_id' => 1,
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);

        $new_user = User::create($input);

        return $new_user->createToken('authToken')->accessToken;
    }

    public function logout() {
        auth()->user()->tokens->each(function ($token, $key) {
            $token->delete();
        });

        return response(['message' => 'Logged out successfully']);
    }
}
