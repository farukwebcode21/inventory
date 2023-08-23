<?php

namespace App\Http\Controllers;

use App\Helper\JWTToken;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller {
    public function UserRegistation(Request $request) {
        try {
            User::create([
                'firstName' => $request->input('firstName'),
                'lastName'  => $request->input('lastName'),
                'email'     => $request->input('email'),
                'password'  => $request->input('password'),
                'mobile'    => $request->input('mobile'),
            ]);
            return response()->json([
                'status'  => 'success',
                'message' => 'Registration successful',
            ]);

        } catch (Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Registration failed',
            ]);
        }
    }

    public function UserLogin(Request $request) {
        $count = User::where('email', '=', $request->input('email'))->where('password', '=', $request->input('password'))->count();
        if ($count == 1) {
            $token = JWTToken::CreateToken($request->input('email'));
            return response()->json([
                'status'  => 'success',
                'message' => 'User Login Successfully',
                'token' => $token
            ]);

        } else {
            return response()->json([
                'status'  => 'failed',
                'message' => 'unauthorized',
            ]);
        }
    }
}
