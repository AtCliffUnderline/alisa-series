<?php

namespace App\Services;


use App\Services\Interfaces\SeriesSelectionServiceInterface;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class SeriesSelectionService implements SeriesSelectionServiceInterface
{
    private $seriesIDs = [];

    public function processSearch(array $seriesIDs)
    {
        $this->seriesIDs = $seriesIDs;
        $result = $this->createQuery();
    }

    private function createQuery(): string
    {
        DB::table('favourites')
            ->select(['series_id', 'count(*) as number'])
            ->whereIn('user_id',function (Builder $query) {
                $query->select('user_id')
                    ->from('favourites');
                foreach($this->seriesIDs as $id) {
                    $query->orWhere('series_id', '=', $id);
                }
            })
            ->groupBy('series_id')
            ->orderByDesc('number')
            ->get();
    }
}
