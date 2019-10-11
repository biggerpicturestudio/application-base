<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use JWTAuth;
use Sentinel;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        $user = Sentinel::getUser();

        return response()->json(compact('user'));
    }

     /**
     * Get a JWT via given credentials.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = request(['email', 'password']);

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['message' => 'Invalid login credential.'], 401);
        }

        $user = Sentinel::getUser();//$request->user();

        return response()->json(compact('token', 'user'));
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        $token = auth()->refresh();

        return response()->json(compact('token'));
    }

    /**
     * Log the user out.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        Sentinel::logout();

        return response()->json(['message' => 'Successfully logged out']);
    }
}
