<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    public function register(Request $request)
    {
        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();

            $token = JWTAuth::fromUser($user);
            // $token = $user->createToken('auth_token')->plainTextToken;
            $success = true;
            $message = 'User register successfully';
            return response()->json(compact('user', 'token'), 201);
        } catch (\Illuminate\Database\QueryException $ex) {
            $success = false;
            $message = $ex->getMessage();
        }

        // response
        // $response = [
        //     'success' => $success,
        //     'message' => $message,
        //     'token' => $token
        // ];
        // return response()->json($response);
    }

    // Login user and issue a token
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email','password');


        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['success' => false, 'error' => 'Invalid credentials'], 401);
        }

        return response()->json([
            'success' => true,
            'token' => $token
        ]);

    }

    /**
     * Logout
     */
    public function logout()
    {
        try {
            Auth::guard('api')->logout();

            return response()->json([
                'message' => 'Successfully logged out'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Something went wrong'
            ], 500);
        }
    }
    public function getUserDetails($username)
    {
        // Assuming the User model has a 'name' field
        $user = User::where('name', $username)->first();

        if ($user) {
            return response()->json($user);
        } else {
            return response()->json(['error' => 'User not found'], 404);
        }
    }

    public function AuthUser()
    {
        return response()->json(Auth::user());
    }
}
