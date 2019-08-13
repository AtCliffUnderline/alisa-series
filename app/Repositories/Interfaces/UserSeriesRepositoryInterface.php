<?php
/**
 * Created by PhpStorm.
 * User: cliffhangles
 * Date: 13/08/2019
 * Time: 22:13
 */

namespace App\Repositories\Interfaces;

use App\Models\UserSeries;
use Illuminate\Database\Eloquent\Collection;

interface UserSeriesRepositoryInterface
{
    public function getUserFavouriteSeries(int $userID): Collection;

    public function addUserFavouriteSeries(int $userID, int $seriesID): UserSeries;
}
