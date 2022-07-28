<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    //login
    public function login(Request $request)
    {
        $credentials = $request->only(['email','password']);

        if(!$token=auth()->attempt($credentials)) 
        {
           return response()->json([
            'success' => false,
            'message' => 'invalid credentials' .$e 
            ]);
        }

        return response()->json([
            'sucess' => true,
            'token' => $token,
            'user' => Auth::user()
        ]);
    }

    //registrartion
    public function register(Request $request)
    {
        $encryptedPass = Hash::make($request->password);

        $user = new User;

        try 
        {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = $encryptedPass;
            $user->save();
            return $this->login($request);
        } 
        catch (Exception $e) 
        {
            return response()->json([
                'success' => false   
            ]);
        }
    }

    //logout
    public function logout(Request $request)
    {
        try 
        {
            JWTAuth::invalidate(JWTAuth::parseToken($request->token));
            return response()->json([
                'success' => true,
                'message' => 'Logout success'
            ]);
        } 
        catch (Exception $e) 
        {
            return response()->json([
                'success' => false,
                'message' => 'Logout unsuccessful' .$e
            ]);
        }
    }
}
