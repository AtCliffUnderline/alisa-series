<?php


namespace App\Services;


use App\Models\Favourite;
use App\Repositories\Interfaces\FavouritesRepositoryInterface;
use App\Repositories\Interfaces\SeriesRepositoryInterface;
use App\Services\Interfaces\LostfilmParsingServiceInterface;
use DiDom\Document;
use GuzzleHttp\Client;

class LostfilmParsingService implements LostfilmParsingServiceInterface
{
    private $client;
    private $lastID;
    private $lostFilmEndpoint = 'https://www.lostfilm.tv/u/';

    public function __construct()
    {
        $lastUser = Favourite::orderBy('user_id','desc')->first();
        $this->lastID = $lastUser->user_id ?? 1;
        $this->client = new Client([
            'cookies' => $this->getAuthCookies()
        ]);
    }

    /**
     * Парсим пользователей LF
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function parse()
    {
        for ($i = $this->lastID+1; $i <= $this->lastID+50; $i++) {
            $response = $this->client->request('GET',$this->lostFilmEndpoint . $i);
            $page = $response->getBody()->getContents();

            $page = new Document($page);
            $favourites = $page->find('#main-left-side > a.text-block');
            foreach($favourites as $favourite) {
                $this->processFavouriteSeries($favourite->attr('href'),$i);
            }
        }
    }


    /**
     * Процессим полученный избранный сериал
     *
     * @param string $link
     * @param int $userID
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    private function processFavouriteSeries(string $link, int $userID)
    {
        /** @var SeriesRepositoryInterface $seriesRepository */
        $seriesRepository = app()->make(SeriesRepositoryInterface::class);
        /** @var FavouritesRepositoryInterface $favouritesRepository */
        $favouritesRepository = app()->make(FavouritesRepositoryInterface::class);

        if(!$series = $seriesRepository->getSeriesByLink($link)) {
            $series = $seriesRepository->addSeries($link);
        }

        $favouritesRepository->addFavourite($userID, $series->id);
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
