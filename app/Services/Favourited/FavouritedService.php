<?php

namespace App\Services\Favourited;

/**
 * Class FavouritedService
 * @package App\Services\Favourited
 */
class FavouritedService
{
    public function listMostFavourited(IFavourited $favourited, $page, $limit)
    {
        return $favourited->list($page, $limit);
    }
}