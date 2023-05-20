<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * User Login
     *
     * @param LoginRequest @login
     * @param LoginRequest @password
     * @return string @token
     * @return bool @status
     * @return object @user
     */
    public function login(LoginRequest $request)
    {
        $loginType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $loginType => $request->login,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('auth-token')->plainTextToken;

            return response()->json([
                'status' => true,
                'token' => $token,
                'data' => $user
            ], 200);
        }

        return response()->json([
            'status' => false,
            'message' => 'Invalid username/email or password'
        ], 400);
    }

    /**
     * User Registration
     *
     * @param RegistrationRequest @username
     * @param RegistrationRequest @email
     * @param RegistrationRequest @phone_number
     * @param RegistrationRequest @password
     * @return bool @status
     * @return string @message
     */
    public function register(RegistrationRequest $request)
    {
        User::create($request->validated());

        return response()->json([
            'status' => true,
            'message' => 'User registered successfully.',
        ], 201);
    }

    /**
     * User Logout
     *
     * @param Request @request
     * @return bool @status
     * @return string @message
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => true,
            'message' => 'Logout successfully.'
        ], 200);
    }
}
