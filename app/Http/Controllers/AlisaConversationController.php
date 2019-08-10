<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\AlisaMainServiceInterface;
use Illuminate\Http\Request;

class AlisaConversationController extends Controller
{
    public function incomingRequest(Request $request, AlisaMainServiceInterface $service)
    {
        return $service->processRequest($request->all());
    }
}
