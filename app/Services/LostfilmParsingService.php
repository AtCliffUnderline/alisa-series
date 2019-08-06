<?php


namespace App\Services;


use App\Models\Favourite;
use DiDom\Document;

class LostfilmParsingService
{
    private $lastID;
    private $lostFilmEndpoint = 'https://www.lostfilm.tv/u/';

    public function __construct()
    {
        $lastUser = Favourite::orderBy('user_id','desc')->first();
        $this->lastID = $lastUser->id ?? 1;
    }

    public function parse()
    {
        for ($i = $this->lastID; $i <= 2; $i++) {
            $this->parsePage($this->lostFilmEndpoint . $i);
        }
    }

    private function parsePage(string $url)
    {
        $page = new Document($url, true);
        $favourites = $page->find('#main-left-side > a.text-block');
        foreach($favourites as $favourite) {
            echo $favourite->attr('href').'\n';
        }
    }
}