<?php

namespace App\Repositories\Interfaces;

use App\Models\Favourite;

interface FavouritesRepositoryInterface
{
    public function addFavourite(int $userID, int $seriesID): Favourite;
}
