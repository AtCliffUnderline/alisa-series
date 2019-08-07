<?php


namespace App\Services;


use App\Services\Interfaces\AlisaMainServiceInterface;
use Yandex\Dialogs\Webhook\Request\Fabric;

class AlisaMainService implements AlisaMainServiceInterface
{
    private $responseFactory;

    public function __construct()
    {
        $data = json_decode(trim(file_get_contents('php://input')), true);
        $dialogRequest = Fabric::initFromArray($data);
        $this->responseFactory = new \Yandex\Dialogs\Webhook\Response\Fabric($dialogRequest);
    }

    public function processRequest()
    {

    }
}