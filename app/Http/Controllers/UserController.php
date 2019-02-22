<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUniqueRequest;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDetails()
    {
        return response()->json(['success' => Auth::user()]);
    }

    /**
     * @param UserUniqueRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function isUnique(UserUniqueRequest $request)
    {
        return response()->json(['success' => 'ok']);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function favourites()
    {
        return response()->json(Auth::user()->favourites()->pluck('image_id'));
    }
}