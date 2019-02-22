<?php

namespace App\Services\Favourited;

use App\Favourite;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Collection;

class ListImages implements IFavourited
{
    /**
     * @param int $page
     * @param int $limit
     * @return LengthAwarePaginator
     * @throws \Exception
     */
    public function list($page, $limit)
    {
        $favourites = array_flip(Favourite::where('created_at', '>=', Carbon::now()->subWeek())->pluck('image_id')->toArray());
        $favouriteImages = Cache::get('favouriteImages');

        if (!$favouriteImages) {
            $apiImages = $this->fetchImages();
            $favouriteImages = array_values(array_filter($apiImages, function($image, $k) use ($favourites) {
                return isset($favourites[$image['id']]);
            }, ARRAY_FILTER_USE_BOTH));

            //cache it for a day
            Cache::add(Favourite::CACHE_KEY, $favouriteImages, 60 * 24);
        }

        $collection = collect($favouriteImages);

        return $this->paginate($collection, $limit, $page);
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    private function fetchImages()
    {
        $client = new Client();
        $res = $client->get('https://jsonplaceholder.typicode.com/photos?_page=', ['' => 1, '_limit' => 1000]);

        if ($res->getStatusCode() == 200) {
            return json_decode($res->getBody(), true); //return null;
        }

        throw new \Exception('Cannot reach API');
    }

    /**
     *
     * @param array|Collection      $items
     * @param int   $perPage
     * @param int  $page
     * @param array $options
     *
     * @return LengthAwarePaginator
     */
    public function paginate($items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}