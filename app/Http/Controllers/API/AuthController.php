<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){
        $data = $request->validate([
            'name'=> 'required|string|max:255',
            'email'=> 'required|email|unique:users,email',
            'password'=>'required|min:6|confirmed',
            'role'=> 'in:admin,user',
            'address'=>'nullable|string|max:255',
            'phone'=>'nullable|string|max:50|unique:users,phone',
            'drivers_license'=>'nullable|string|max:50|unique:users,drivers_license',
            'is_active'=>'boolean',
        ]);
        $user = User::query()->create([
           'name'=>$data['name'],
           'email'=>$data['email'],
           'password'=>bcrypt($data['password']),
           'role'=>$data['role'] ?? 'user',
           'address'=>$data['address'] ?? null,
           'phone'=>$data['phone'] ?? null,
           'drivers_license'=>$data['drivers_license'] ?? null,
           'is_active'=>$data['is_active'] ?? true,
        ]);
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json(['user'=>$user,'token'=>$token],201);
    }
    public function login(Request $request){
        $data = $request->validate([
            'email'=> 'required|string|email',
            'password'=>'required|string',
        ]);
        $user = User::query()->where('email', $data['email'])->first();
        if(!$user || !Hash::check($data['password'],$user->password)){
            return response()->json(['message' => 'Incorrect email or password'], 401);
        }
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json(['user'=>$user,'token'=>$token],200);
    }
    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->noContent();
    }
}
