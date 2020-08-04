<?php

namespace App\Console\Commands;

use App\Candle;
use App\Currency;
use App\Helpers\Oanda;
use Carbon\Carbon;
use Illuminate\Console\Command;

class GetCandels extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'candles:get';

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
     * @return int
     */
    public function handle()
    {
        $start_date = Candle::min('date');

        if(!isset($start_date))
        {
            $start_date = Carbon::yesterday()->subDays(15);
        }

        $currencies = Currency::active()->get()
                                        ->pluck('name')
                                        ->chunk(4);

        foreach ($currencies as $codes) {
            Oanda::getFluctuations($start_date, Carbon::yesterday(), $codes);
        }
    }
}
