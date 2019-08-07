<?php


namespace App\Repositories;


use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function getUserByYandexID(string $yandexID): ?User
    {
        return User::where('yandex_user_id', '=', $yandexID)->first();
    }

    public function addUserByYandexID(string $yandexID): User
    {
        $user = new User();
        $user->yandex_user_id = $yandexID;
        $user->save();
        return $user;
    }
}