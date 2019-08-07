<?php

namespace App\Repositories\Interfaces;

use App\Models\User;

interface UserRepositoryInterface
{
    public function getUserByYandexID(string $yandexID): ?User;

    public function addUserByYandexID(string $yandexID): User;
}