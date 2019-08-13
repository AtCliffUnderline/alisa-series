<?php

namespace App\Repositories;


use App\Models\Favourite;
use App\Repositories\Interfaces\FavouritesRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class FavouritesRepository implements FavouritesRepositoryInterface
{
    public function addFavourite(int $userID, int $seriesID): Favourite
    {
        $favourite = new Favourite();
        $favourite->user_id = $userID;
        $favourite->series_id = $seriesID;
        $favourite->save();
        return $favourite;
    }

}
