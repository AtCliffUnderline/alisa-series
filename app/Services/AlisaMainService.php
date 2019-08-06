<?php


namespace App\Services;


use Yandex\Dialogs\Webhook\Request\Fabric;
use Yandex\Dialogs\Webhook\Response\DTO\Buttons\Button;
use Yandex\Dialogs\Webhook\Response\Formatters\Formatter;

class AlisaMainService
{
    private $responseFactory;

    public function __construct(array $data)
    {
        $dialogRequest = Fabric::initFromArray($data);
        $this->responseFactory = new \Yandex\Dialogs\Webhook\Response\Fabric($dialogRequest);
    }

    public function testResponse()
    {
        $button1 = new Button();
        $button1
            ->setTitle('Кнопка1')
            ->setUrl('https://ya.ru');

        $button2 = new Button();
        $button2
            ->setTitle('Кнопка2');

        $response = $this->responseFactory
            ->setText('Привет')
            ->setTts('Привет')
            ->addButton($button1)
            ->addButton($button2)
            ->buildResponse();

        return Formatter::toArray($response);
    }
}