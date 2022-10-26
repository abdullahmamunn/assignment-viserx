<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails())
        {
            return response([
                'errors'=>$validator->errors()->all()
            ], 422);
        }

        $user = User::where('email', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('my-token')->accessToken;
                $response = ['token' => $token];
                return response($response, 200);
            } else {
                $response = ["message" => "Password mismatch"];
                return response($response, 422);
            }
        } else {
            $response = ["message" =>"User does not exist"];
            return response($response, 422);
        }
    }

    public function register(Request $request)
    {
        // return $request->all();
        $validator = Validator::make($request->all(),[
            'username' => 'required|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|unique:users,phone',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails())
        {
            return response([
                'errors'=>$validator->errors()->all()
            ], 422);
        }
        $request['name'] = $request->username;
        $request['password'] = Hash::make($request['password']);
        $request['type'] = $request['type'] ? $request['type']  : 2;
        // return $request->toArray();
        $user = User::create($request->toArray());
        $token = $user->createToken('my-token')->accessToken;
        $response = ['token' => $token];
        return response($response, 200);
    }

    public function logout (Request $request) {
        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }
}
