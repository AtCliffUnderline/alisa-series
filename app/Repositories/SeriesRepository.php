<?php

namespace App\Repositories;


use App\Model\Series;
use App\Repositories\Interfaces\SeriesRepositoryInterface;

class SeriesRepository implements SeriesRepositoryInterface
{
    public function getSeriesByLink(string $link): ?Series
    {
        return Series::where('series_link', '=', $link)->first();
    }

    public function addSeries(string $seriesLink): Series
    {
        $series = new Series();
        $series->series_link = $seriesLink;
        $series->save();
        return $series;
    }
}
