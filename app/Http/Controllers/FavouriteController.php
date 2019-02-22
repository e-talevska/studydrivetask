<?php

namespace App\Http\Controllers;

use App\Favourite;
use App\Http\Requests\FavouriteRequest;
use App\Services\Favourited\FavouritedService;
use App\Services\Favourited\ListImages;
use App\Services\Favourited\ListUsers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class FavouriteController extends Controller
{
    protected $service;

    public function __construct(FavouritedService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page = $request->request->get('page', 1);
        $limit = $request->request->get('limit', 10);

        $dt = Carbon::now();
        if ($dt->isWeekend()) {
            $strategy = new ListUsers();
        } else {
            $strategy = new ListImages();
        }

        return response()->json($this->service->listMostFavourited($strategy, $page, $limit));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  FavouriteRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FavouriteRequest $request)
    {
        $favourite = Favourite::where('user_id', Auth::id())
            ->where('image_id',  $request->image_id)
            ->first();

        if ($favourite) {
            return response()->json(['error' => 'Image already in favourites'], 409);
        }

        $input = $request->all();
        $favourite = Auth::user()->favourites()->create($input);

        Cache::forget(Favourite::CACHE_KEY);

        return response()->json([
            'success' => (bool) $favourite,
            'message' => $favourite ? 'Successfully added to favourites!' : 'Error while adding to favourites'
        ]);
    }

    /**
     * Determine whether an image has been marked as favorite by a user.
     *
     * @return boolean
     */
    public function favourited(FavouriteRequest $request)
    {
        return (bool) Favourite::where('user_id', Auth::id())
            ->where('image_id',  $request->image_id)
            ->first();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $image_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($image_id)
    {
        $favourite = Favourite::where('user_id', Auth::id())
            ->where('image_id',  $image_id)
            ->delete();

        Cache::forget(Favourite::CACHE_KEY);

        return response()->json([
            'success' => (bool) $favourite,
            'message' => $favourite ? 'Successfully removed from favourites!' : 'Error while removing from favourites'
        ], $favourite ? 200 : 500);
    }
}
