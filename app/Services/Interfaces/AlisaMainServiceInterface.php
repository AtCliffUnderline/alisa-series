<?php

namespace App\Services\Interfaces;

interface AlisaMainServiceInterface
{
    public function processRequest(array $requestArr): array;
}
