<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Patient;

class PatientAuth extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $patient = Patient::where('email', $request->email)->first();
        if (!$patient || !Hash::check($request->password, $patient->password)) {
            return response()->json(['message' => 'invalid credentials'], 401);
        }

        $token = $patient->createToken('api-token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $patient
        ]);
    }
}
