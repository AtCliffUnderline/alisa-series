<?php

namespace App\Services;


use DiDom\Document;
use GuzzleHttp\Client;

class AvitoParsingService
{
    private $avitoEndpoint = 'https://www.avito.ru/sankt-peterburg/kvartiry/sdam/na_dlitelnyy_srok/2-komnatnye?cd=1&pmax=30000&pmin=23000&user=1';
    private $page;
    private $fileDirectory = __DIR__.'/../../flats.json';
    private $watchedFlats;

    public function __construct()
    {
        $this->getAvitoPage();
    }

    private function getAvitoPage()
    {
        $client = new Client();
        $response = $client->request('GET',$this->avitoEndpoint);
        $this->page = $response->getBody()->getContents();
        $this->getExistedFlats();
        $this->parsePage();
        $this->putFlats();
    }

    private function parsePage()
    {
        $this->page = new Document($this->page);
        $flats = $this->page->find('.js-item-extended');
        foreach($flats as $flat) {
            $aTag = $flat->find('a');
            $title = $aTag[2]->getAttribute('title');
            $link = $aTag[2]->getAttribute('href');
            if(!in_array($link,$this->watchedFlats)) {
                $this->sendVKMessage("Новая квартира на авито <br> $title <br> avito.ru".$link);
                $this->watchedFlats[] = $link;
            }
        }
    }

    private function getExistedFlats()
    {
        $this->watchedFlats = json_decode(file_get_contents($this->fileDirectory));
    }

    private function putFlats()
    {
        file_put_contents($this->fileDirectory,json_encode($this->watchedFlats));
    }

    private function sendVKMessage($message)
    {
        foreach([29573998,218176545] as $id) {
            $messageArray = [
                'v' => '5.80',
                'access_token' => '39ee15ff5cb45ec924a483b919d9eeaffafc75b467f96294a2136ebfe3cabfdf2c777af5e91dfaa1e994a',
                'user_id' => $id,
                'message' => $message
            ];
            $client = new Client();
            $client->get('https://api.vk.com/method/messages.send', [
                'query' => $messageArray
            ]);
        }
    }

}
