<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PhpParser\NodeVisitor\FirstFindingVisitor;

class UserController extends Controller
{
    public function register(RegisterRequest $request){
        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
        ]);
        $token=$user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'message'=>'register successful',
            'user'=>$user,
            'token'=>$token,
        ],201);
    }
    public function login(LoginRequest $request){
         $user = User::where('email', $request->email)->first();
         if(!$user || !Hash::check($request->password, $user->password)){
            return response()->json(['message'=>'invalid credentials',],403);
         }
         return response()->json([
            'message'=>'logged successful',
            'token' => $user->createToken('auth_token')->plainTextToken,
            'user'=>$user
         ]);
    }
}
