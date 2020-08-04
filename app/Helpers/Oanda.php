<?php

namespace App\Helpers;

use App\Candle;
use Carbon\Carbon;
use GuzzleHttp\Client;

class Oanda
{
    public static function getFluctuations($start_date, $end_date = null, $base_currencies = [])
    {
        $start_date = $start_date->format('yy-m-d');

        if(!isset($end_date))
        {
            $end_date = Carbon::yesterday();
        }

        $end_date = $end_date->format('yy-m-d');

        if (!isset($base_currencies))
        {
            $base_currencies = ["EUR", "USD", "CAD", "AUD"];
        }

        foreach ($base_currencies as $base) {
            $end_point  = "https://www.oanda.com/rates/api/v2/rates/candles.json";
            $end_point .= "?base=" . $base;
            $end_point .= "&start_time=" . $start_date;
            $end_point .= "&end_time="   . $end_date;

            $end_point .= "&api_key=" . config('oanda.oanda_api_key', "GGJJY4g3pShdOs92QQzQwpDI") . "&quote=TND";

            try {
                $client = new Client();

                $request = $client->request('GET', $end_point);

                $candles = json_decode($request->getBody()->__toString())->quotes;

            } catch (\Exception $exception) {
                return $exception->getMessage();
            }

            if ($candles)
            {
                foreach ($candles as $candle) {
                    Candle::create([
                        'currency_code'  =>  $candle->base_currency,
                        'date' =>  Carbon::parse($candle->open_time)->format('yy-m-d'),
                        'value' =>  $candle->average_midpoint,
                    ]);
                }
            }
        }

    }
}
