<?php

namespace App\Services\Favourited;

use App\User;
use Carbon\Carbon;

class ListUsers implements IFavourited
{
    /**
     * @param int $page
     * @param int $limit
     * @return mixed
     */
    public function list($page, $limit)
    {
        return User::whereHas('favourites', function ($query) {
            $query->where('created_at', '>=', Carbon::now()->subWeek());
        })->paginate($limit);
    }
}