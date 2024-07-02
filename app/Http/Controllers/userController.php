<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class userController extends Controller
{
    public function register(Request $request){
        $request->validate([
            'fullname' => 'required|string',
            'username' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string',
            'tanggal_lahir' => 'required|string',
            'kelamin' => 'required|string',
            'alamat' => 'required|string',
        ]);

        $user = new User([
            'fullname' => $request->fullname,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'tanggal_lahir' => $request->tanggal_lahir,
            'kelamin' => $request->kelamin,
            'alamat' => $request->alamat,
        ]);

        $user->save();

        return response()->json([
            'message' => 'User berhasil didaftarkan',
        ], 201);
    }


    public function login (Request $request){
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)){
            return response()->json([
                'message' => 'Username atau password salah',
            ], 401);
        }

        return response()->json([
            'message' => 'Login berhasil',
            'user' => $user,
        ], 200);
    }

    
}
