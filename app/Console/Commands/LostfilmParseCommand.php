<?php

namespace App\Console\Commands;

use App\Services\Interfaces\LostfilmParsingServiceInterface;
use Illuminate\Console\Command;

class LostfilmParseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lostfilm:parse';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param LostfilmParsingServiceInterface $lostfilmParsingService
     * @return void
     */
    public function handle(LostfilmParsingServiceInterface $lostfilmParsingService)
    {
        $lostfilmParsingService->parseFilms();
        $lostfilmParsingService->getSeriesNames();
    }
}
