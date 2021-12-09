<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\User;
use Validator;

class AuthController extends Controller
{
    // REGISTER FUNCTION FOR TESTING PURPOSES, UNCOMMENT IF NEEDED
    // public function register(Request $request)
    // {
    //     $request->validate([
    //     'first_name' => 'required|string',
    //     'last_name' => 'required|string',
    //     'user_email' => 'required|string|email|unique:users',
    //     'password' => 'required|string|',
    //     'c_password'=>'required|same:password',
    //     ]);

    //     $user = new User([
    //     'first_name' => $request->first_name,
    //     'last_name' => $request->last_name,
    //     'user_email' => $request->user_email,
    //     'user_password' => bcrypt($request->password),
    //     'verified' => 1,
    //     'remember_token' => Str::random(10),
    //     'role_id' => 1,
    //     'user_image' => 'this is a path to a user\'s image',
    //     'email_verified_at' => now(),
    //     ]);
    //     if($user->save()){
    //     return response()->json([
    //         'message' => 'Successfully created user!'
    //     ], 201);
    //     }else{
    //     return response()->json(['error'=>'Provide proper details']);
    //     }
    // }

    /**
    * Login user and create token
    *
    * @param  [string] email
    * @param  [string] password
    * @param  [boolean] remember_me
    * @return [string] access_token
    * @return [string] token_type
    * @return [string] expires_at
    */
    public function login(Request $request)
    {
        $credentials = $request->validate([
        'email' => 'required|string|email',
        'password' => 'required|string',
        ]);
        // $credentials = request(['email', 'password']);
        if(!Auth::attempt(['user_email' => $credentials['email'], 'password' => $credentials['password']]))
        return response()->json([
            'message' => 'Wrong email/Password. Please try again'
        ], 401);
        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        // if ($request->remember_me)
        // $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();
        return response()->json([
        'access_token' => $tokenResult->accessToken,
        'token_type' => 'Bearer',
        'expires_at' => Carbon::parse(
            $tokenResult->token->expires_at
        )->toDateTimeString()
        ]);
    }

    /**
    * Get the authenticated User
    *
    * @return [json] user object
    */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    /**
    * Logout user (Revoke the token)
    *
    * @return [string] message
    */
    public function logout(Request $request)
    {
        $request->user()->token()->delete();
        return response()->json([
        'message' => 'Successfully logged out'
        ]);
    }
}
