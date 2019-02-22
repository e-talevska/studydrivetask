<?php

namespace App\Services\Favourited;

interface IFavourited
{
    /**
     * @param int $page
     * @param int $limit
     * @return mixed
     */
    public function list($page, $limit);
}