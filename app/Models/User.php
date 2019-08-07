<?php

namespace App\Models;

use App\ModelHelper;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, ModelHelper;

    protected $table = 'users';
    public $timestamps = false;

    public function userSeries()
    {
        return $this->hasMany(UserSeries::class, 'user_id', 'id');
    }
}
