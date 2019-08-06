<?php


namespace App\Services;


use App\Models\Favourite;
use App\Repositories\Interfaces\FavouritesRepositoryInterface;
use App\Repositories\Interfaces\SeriesRepositoryInterface;
use App\Services\Interfaces\LostfilmParsingServiceInterface;
use DiDom\Document;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class LostfilmParsingService implements LostfilmParsingServiceInterface
{
    /** @var SeriesRepositoryInterface $seriesRepository */
    private $seriesRepository;
    /** @var FavouritesRepositoryInterface $favouritesRepository */
    private $favouritesRepository;

    private $client;
    private $lastID;
    private $lostFilmEndpoint = 'https://lostfilm.tv';
    private $lostFilmUserEndpoint = 'https://www.lostfilm.tv/u/';

    /**
     * LostfilmParsingService constructor.
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct()
    {
        $this->lastID = Cache::get('lastUser');
        if (!$this->lastID) {
            $lastUser = Favourite::orderBy('user_id', 'desc')->first();
            $this->lastID = $lastUser->user_id ?? 1;
        }

        $this->client = new Client([
            'cookies' => $this->getAuthCookies()
        ]);

        $this->seriesRepository = app()->make(SeriesRepositoryInterface::class);
        $this->favouritesRepository = app()->make(FavouritesRepositoryInterface::class);
    }

    /**
     * Парсим пользователей LF
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function parseFilms()
    {
        for ($i = $this->lastID + 1; $i <= $this->lastID + 50; $i++) {
            $response = $this->client->request('GET', $this->lostFilmUserEndpoint . $i);
            $page = $response->getBody()->getContents();

            $page = new Document($page);
            $favourites = $page->find('#main-left-side > a.text-block');
            foreach ($favourites as $favourite) {
                $this->processFavouriteSeries($favourite->attr('href'), $i);
            }
            Cache::put('lastUser', $i, 60 * 60 * 12);
        }
    }

    public function getSeriesNames()
    {
        $this->seriesRepository->getSeriesWithoutName(10, function ($series) {
            foreach ($series as $oneSeries) {
                $response = $this->client->request('GET', $this->lostFilmEndpoint . $oneSeries->series_link);
                $page = $response->getBody()->getContents();

                $page = new Document($page);
                $title = $page->find('#left-pane > div:nth-child(1) > h1 > div.title-ru');
                $this->seriesRepository->addSeriesName($oneSeries, $title[0]->text());
            }
        });
    }


    /**
     * Процессим полученный избранный сериал
     *
     * @param string $link
     * @param int $userID
     */
    private function processFavouriteSeries(string $link, int $userID)
    {
        if (!$series = $this->seriesRepository->getSeriesByLink($link)) {
            $series = $this->seriesRepository->addSeries($link);
        }

        $this->favouritesRepository->addFavourite($userID, $series->id);
    }

    /**
     * Создаем авторизационные куки для LF
     *
     * @return \GuzzleHttp\Cookie\CookieJar
     */
    private function getAuthCookies()
    {
        $domain = '.lostfilm.tv';
        $values = ['lf_session' => config('yadialogs.lf_token')];

        return \GuzzleHttp\Cookie\CookieJar::fromArray($values, $domain);
    }
}
