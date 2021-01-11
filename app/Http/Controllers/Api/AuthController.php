<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\Client;

class AuthController extends BaseController
{
    public function register(UserRequest $request)
    {
        $request['password'] = Hash::make($request->input('password'));
//        dd($request['password']);
        $user = User::create($request->toArray());
//        $client = Client::where('password_client', 1)->first();
        $token = $user->createToken('Laravel Password Grant Client')->accessToken;
        $response = ['token' => $token];
//        return $this->

        return response($response, 200);
    }

    public function login(UserRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                $response = ['token' => $token];
                return response($response, 200);
            } else {
                $response = "Password miss match";
                return $this->errorResponse($response,422);
            }
        }

        $response = 'User does not exist';
        return $this->errorResponse($response,422);
    }

    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();

        $response = 'You have been succesfully logged out!';
        return response($response, 200);

    }

    public function getTokenAndRefreshToken(Client $client, $email, $password)
    {
        $client = Client::where('password_client', 1)->first();
        $http = new Client;
        $response = $http->request();
    }
}
