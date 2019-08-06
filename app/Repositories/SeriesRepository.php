<?php

namespace App\Repositories;


use App\Model\Series;
use App\Repositories\Interfaces\SeriesRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

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

    public function getSeriesWithoutName(int $chunk, \Closure $function): Collection
    {
        return Series::whereNull('series_name')->chunk($chunk,$function);
    }

    public function addSeriesName(Series $series, string $seriesName): void
    {
        $series->series_name = $seriesName;
        $series->update();
    }
}
