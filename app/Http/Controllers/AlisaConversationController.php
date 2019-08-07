<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\AlisaMainServiceInterface;

class AlisaConversationController extends Controller
{
    public function incomingRequest(AlisaMainServiceInterface $service)
    {
        $service->processRequest();
    }
}
