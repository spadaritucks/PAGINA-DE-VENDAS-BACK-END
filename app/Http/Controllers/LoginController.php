<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function Login(Request $request)
    {

            if (Auth::attempt(['cpf' => $request->cpf, 'password' => $request->password])) {
                $user = Auth::user();

                $token =  $request->user()->createToken('api-token', [], now()->addHours(1))->plainTextToken;

                return response()->json([
                    'status' => true,
                    'message' => "Bem vindo!",
                    'token' => $token,
                    'user' => $user
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'CPF ou senha incorreta!',
                ], 404);
            }
        
    }
}
