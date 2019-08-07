<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\AlisaMainServiceInterface;
use Yandex\Dialogs\Webhook\Response\Formatters\Formatter;

class AlisaConversationController extends Controller
{
    public function incomingRequest(AlisaMainServiceInterface $service)
    {
        return Formatter::toArray($service->processRequest());
    }
}
