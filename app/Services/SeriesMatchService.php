<?php

namespace App\Services;


use App\Repositories\Interfaces\SeriesRepositoryInterface;

class SeriesMatchService
{
    /** @var SeriesRepositoryInterface $seriesRepository */
    private $seriesRepo;
    private $series;
    private $predictedSeries = [];

    /**
     * SeriesMatchService constructor.
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct()
    {
        $this->seriesRepo = app()->make(SeriesRepositoryInterface::class);
        $this->series = $this->seriesRepo->getSeries()->toArray();
        foreach ($this->series as $key => $series) {
            $this->series[$key]['series_name'] = mb_strtolower(preg_replace('/[^\p{L}0-9 ]/iu', '', $series['series_name']));
        }
    }

    public function predict(string $phrase)
    {
        $searchPhrase = '';
        $words = explode(' ', $phrase);
        for ($i = 0; $i < sizeof($words); $i++) {
            $searchPhrase = trim(mb_strtolower(implode(' ', [$searchPhrase, $words[$i]])));
            if($searchPhrase == '') {
                break;
            }
            foreach ($this->series as $series) {
                if ($series['series_name'] == $searchPhrase) {
                    $this->predictedSeries[] = $series['id'];
                    $this->predict(implode(' ', array_slice($words, $i + 1)));
                    break;
                }
            }
        }
        return $this->predictedSeries;
    }
}
