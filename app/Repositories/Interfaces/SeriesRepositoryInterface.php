<?php

namespace App\Repositories\Interfaces;

use App\Model\Series;

interface SeriesRepositoryInterface
{
    public function getSeriesByLink(string $link): ?Series;

    public function addSeries(string $seriesLink): Series;
}
