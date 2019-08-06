<?php

namespace App\Services\Interfaces;

interface LostfilmParsingServiceInterface
{
    public function parseFilms();

    public function getSeriesNames();
}
