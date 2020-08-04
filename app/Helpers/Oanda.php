<?php

namespace App\Helpers;

use App\Candle;
use Carbon\Carbon;
use GuzzleHttp\Client;

class Oanda
{
    public static function getFluctuations($start_date, $end_date = null, $quotes = [], $base = "TND")
    {
        $start_date = $start_date->format('yy-m-d');

        if(!isset($end_date))
        {
            $end_date = Carbon::yesterday();
        }

        $end_date = $end_date->format('yy-m-d');

        if (!isset($quotes))
        {
            $quotes = ["EUR", "USD", "CAD", "AUD"];
        }

        $end_point  = "https://www.oanda.com/rates/api/v2/rates/candles.json";
        $end_point .= "?base=" . $base;
        $end_point .= "&start_time=" . $start_date;
        $end_point .= "&end_time="   . $end_date;

        $quotes_to_string = "";

        foreach ($quotes as $quote) {
            $quotes_to_string .= "&quote=" . $quote;
        }

        $end_point .= "&api_key=" . env('OANDA_API_KEY', "GGJJY4g3pShdOs92QQzQwpDI") . $quotes_to_string;

        try {
            $client = new Client();

            $request = $client->request('GET', $end_point);

            $candles = json_decode($request->getBody()->__toString())->quotes;

            // $candles = json_decode('[
            //     {
            //         "base_currency": "TND",
            //         "quote_currency": "ADF",
            //         "start_time": "2020-08-02T00:00:00+00:00",
            //         "open_time": "2020-08-02T00:00:00+00:00",
            //         "close_time": "2020-08-02T23:59:59+00:00",
            //         "average_bid": "2.00483",
            //         "average_ask": "2.05343",
            //         "average_midpoint": "2.02913"
            //     },
            //     {
            //         "base_currency": "TND",
            //         "quote_currency": "ADP",
            //         "start_time": "2020-08-02T00:00:00+00:00",
            //         "open_time": "2020-08-02T00:00:00+00:00",
            //         "close_time": "2020-08-02T23:59:59+00:00",
            //         "average_bid": "50.8534",
            //         "average_ask": "52.0860",
            //         "average_midpoint": "51.4697"
            //     }]');
        } catch (\Exception $exception) {
            dd($exception->getMessage());
            return $exception->getMessage();
        }

        if ($candles)
        {
            foreach ($candles as $candle) {
                Candle::create([
                    'base'  =>  $candle->base_currency,
                    'quote' =>  $candle->quote_currency,
                    'date' =>  Carbon::parse($candle->open_time)->format('yy-m-d'),
                    'value' =>  $candle->average_midpoint,
                ]);
            }
        }
    }
}
