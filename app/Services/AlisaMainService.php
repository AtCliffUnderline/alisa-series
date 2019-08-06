<?php


namespace App\Services;


class AlisaMainService
{
    public function __construct(array $data)
    {
        file_put_contents(__DIR__ . '/../check.txt',json_encode($data));
    }
}