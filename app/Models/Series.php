<?php

namespace App\Model;

use App\ModelHelper;
use App\Models\Favourite;
use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    use ModelHelper;

    protected $table = 'series';

    public $timestamps = false;

    public function favourites()
    {
        return $this->hasMany(Favourite::class, 'series_id', 'id');
    }
}
