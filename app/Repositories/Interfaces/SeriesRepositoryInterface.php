<?php

namespace App\Repositories\Interfaces;

use App\Model\Series;
use Illuminate\Database\Eloquent\Collection;

interface SeriesRepositoryInterface
{
    public function getSeriesByLink(string $link): ?Series;

    public function addSeries(string $seriesLink): Series;

    public function getSeriesWithoutName(int $chunk, \Closure $function);

    public function addSeriesName(Series $series, string $seriesName): void;

    public function getSeries(): ?Collection;
}
