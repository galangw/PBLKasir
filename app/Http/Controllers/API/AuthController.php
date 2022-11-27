<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email'     => 'required',
            'password'  => 'required'
        ]);
        $data = $validate->validated();
        if (!Auth::attempt($data)) {
            return response()->json([
                'status'   =>  'Gagal',
                'message'   =>  'user tidak ditemukan',
            ]);
        }
        $user = User::where('email', Auth::user()->email)->first();
        $token = $user->createToken('token-auth')->plainTextToken;
        $respon = [
            'status' => 'success',
            'msg' => 'Login successfully',
            'errors' => null,
            'content' => [
                'status_code' => 200,
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]
        ];
        return response()->json($respon, 200);
    }
    public function register(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name'      =>  'required',
            'email'     =>  'required',
            'password'  =>  'required'
        ]);
        $validated = $validate->validated();
        $validated['password'] = Hash::make($validated['password']);
        try {
            $user = User::create($validated);
            return response()->json([
                'status'    =>  'sukses',
                'message'   =>  'Sukes Register ' . $validated['email'],
                'token'     => $user->createToken('auth-toke')->plainTextToken
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status'    =>  'gagal',
                'message'   =>  $th->getMessage()
            ]);
        }
    }
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json([
            'status'    =>  'sukses',
            'message'   =>  'Berhasil Log Out'
        ], 200);
    }
}
