<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthTest extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $guards = ['admin', 'doctor', 'patient'];

        foreach ($guards as $guard) {

            $user = Auth::guard($guard)
                ->getProvider()
                ->retrieveByCredentials(['email' => $request->email]);

            if (!$user) {
                continue;
            }

            if (! Hash::check($request->password, $user->password)) {
                continue;
            }

            Auth::guard($guard)->login($user);

            $user->tokens()->delete();
            $token = $user->createToken($guard.'_token',[$guard])->plainTextToken;

            return response()->json([
                'message' => 'successful',
                'role' => $guard,
                'token' => $token,
                'user' => $user,
            ]);
        }

        return response()->json([
            'message' => 'invalid credentials'
        ], 401);
    }
}
