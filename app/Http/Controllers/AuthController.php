<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Validator;

use App\Models\User;

use App\Models\PasswordReset;
use App\Mail\PasswordResetMailable;

class AuthController extends Controller
{
    // REGISTER FUNCTION FOR TESTING PURPOSES, UNCOMMENT IF NEEDED
    public function register(Request $request)
    {
        $request->validate([
        'first_name' => 'required|string',
        'last_name' => 'required|string',
        'user_email' => 'required|string|email|unique:users',
        'password' => 'required|string|',
        'c_password'=>'required|same:password',
        ]);

        $user = new User([
        'first_name' => $request->first_name,
        'last_name' => $request->last_name,
        'user_email' => $request->user_email,
        'user_password' => bcrypt($request->password),
        'verified' => 1,
        'remember_token' => Str::random(10),
        'role_id' => 1,
        'user_image' => 'this is a path to a user\'s image',
        'email_verified_at' => now(),
        ]);
        if($user->save()){
        return response()->json([
            'message' => 'Successfully created user!'
        ], 201);
        }else{
        return response()->json(['error'=>'Provide proper details']);
        }
    }

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

    // Forgot Password Functionality
    public function sendToken(Request $request)
    {
        $user = User::where('user_email', $request->email)->first();

        if(!isset($user->id))
        {
            return response()->json(['error' => 'User with this email does not exist'], 401);
        }

        $token = Str::random(32);

        Mail::to($user->user_email)->send(new PasswordResetMailable($token));

        $password_reset = new PasswordReset();
        $password_reset->user_email = $user->user_email;
        $password_reset->token = $token;
        $password_reset->save();

        return response()->json([
            'message' => 'Recovery email has been sent',
            'access_token' => $token,
        ], 200);
    }
    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|',
            'c_password'=>'required|same:password',
            'token' => 'string',
        ]);
        
        $password_reset = PasswordReset::where('token', $request->token)->first();
        $user = User::where('user_email', $password_reset->user_email)->first();

        if(!isset($password_reset->id))
        {
            return response()->json(['message' => 'Something went wrong please try again'], 401);
        }

        $user->user_password = bcrypt($request->password);
        $user->save();

        return response()->json([
            'message' => 'Password Changed',
        ], 200);

    }
}
