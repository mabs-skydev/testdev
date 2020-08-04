<?php

namespace App\Http\Controllers;

use App\Candle;
use App\Currency;
use Carbon\Carbon;
use Illuminate\Http\Request;
use stdClass;

class CandleController extends Controller
{
    public function currencies()
    {
        $datasets = [];
        $quotes = ["EUR", "USD", "CAD", "AUD"];

        foreach ($quotes as $quote) {

            $candles = Candle::where('currency_code', $quote)
                                ->where('date', '>=', Carbon::today()->subDays(15))
                                ->get();

            $dataset = new stdClass();
            $data = new stdClass();

            $dataset->name = $quote;

            foreach ($candles as $candle) {
                $data->{$candle->date} = $candle->value;
            }

            $dataset->data = $data;

            $datasets[] = $dataset;
        }

        return response()->json([
            'datasets'  => $datasets
        ]);
    }

    public function crypto()
    {
        $datasets = [];
        $quotes = ["BTC", "ETH"];

        foreach ($quotes as $quote) {

            $candles = Candle::where('currency_code', $quote)
                                ->where('date', '>=', Carbon::today()->subDays(15))
                                ->get();

            $dataset = new stdClass();
            $data = new stdClass();

            $dataset->name = $quote;

            foreach ($candles as $candle) {
                $data->{$candle->date} = $candle->value;
            }

            $dataset->data = $data;

            $datasets[] = $dataset;
        }

        return response()->json([
            'datasets'  => $datasets
        ]);
    }
}
