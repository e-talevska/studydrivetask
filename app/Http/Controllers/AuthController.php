<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUniqueRequest;
use App\User;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = [
            'email' => request('email'),
            'password' => request('password')
        ];

        if (Auth::attempt($credentials)) {
            $success['token'] = Auth::user()->createToken('MyApp')->accessToken;
            $success['name'] = Auth::user()->name;

            return response()->json(['success' => $success]);
        }

        return response()->json(['error' => 'Unauthorised'], 401);
    }

    /**
     * @param UserCreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(UserCreateRequest $request)
    {
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);

        $user = User::create($input);
        $success['token'] = $user->createToken('MyApp')->accessToken;
        $success['name'] = $user->name;

        return response()->json(['success' => $success]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        if (Auth::check()) {
            Auth::user()->token()->revoke();

            return response()->json([
                'status' => 'success',
                'msg' => 'Logged out Successfully.'
            ]);
        }

        return response()->json(['error' => 'Unauthorised'], 401);
    }
}
