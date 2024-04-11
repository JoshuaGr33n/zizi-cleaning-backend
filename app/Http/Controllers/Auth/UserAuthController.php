<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use Laravel\Passport\Token;


class UserAuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ]);

        $data['password'] = bcrypt($request->password);

        $user = User::create($data);

        $token = $user->createToken('API Token')->accessToken;

        return response(['user' => $user, 'token' => $token]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        $check = User::where('email', $request->email)->first();

        if ($check && !$check->is_active) {
            // Log the attempt or handle inactive users specifically if needed
            return response(['error_message' => 'This account is not active.'], 401);
        }

        $user = User::where('email', $request->email)->where('is_active', true)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            $token = $user->createToken('auth')->accessToken;

            return response(['user' => $user->first_name, 'token' => $token, 'role' => $user->role]);
        }
        if ($user && !$user->is_active) {
            // Log the attempt or handle inactive users specifically if needed
            return response(['error_message' => 'Your account is not active.'], 401);
        }

        return response(['error_message' => 'Incorrect email or password.'], 401);
    }


    public function profile(Request $request)
    {
        return response(['data' => $request->user()]);
        //   return $this->response($user, Response::HTTP_OK);
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        // $user->tokens->each(function (Token $token) {
        //     $token->delete();
        // });

        $user->token()->revoke();

        return response()->json(['message' => 'Successfully logged out']);
    }
}
