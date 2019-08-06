<?php

namespace App\Models;

use App\Model\Series;
use App\ModelHelper;
use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
    use ModelHelper;

    protected $table = 'favourites';

    public $timestamps = false;

    public function series()
    {
        return $this->belongsTo(Series::class, 'series_id', 'id');
    }
}
