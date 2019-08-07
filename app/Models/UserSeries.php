<?php

namespace App\Models;

use App\ModelHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class UserSeries extends Model
{
    use Notifiable, ModelHelper;

    protected $table = 'user_series';
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
