<?php

namespace App\Repositories;


use App\Models\UserSeries;
use App\Repositories\Interfaces\UserSeriesRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class UserSeriesRepository implements UserSeriesRepositoryInterface
{
    public function getUserFavouriteSeries(int $userID): Collection
    {
        return UserSeries::where('user_id', '=', $userID)
            ->where('is_favourite', '=', 1)->get();
    }

    public function addUserFavouriteSeries(int $userID, int $seriesID): UserSeries
    {
        $userSeries = new UserSeries();
        $userSeries->user_id = $userID;
        $userSeries->series_id = $seriesID;
        $userSeries->is_favourite = 1;
        $userSeries->save();
        return $userSeries;
    }
}
