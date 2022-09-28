<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use DB;

class Market extends Model
{
    use HasFactory;
    protected $table = 'market';

    public function updateMarketData() {

        $cm_data = $this->coinmarketcap()->data->EWT[0]->quote->USD;

        DB::table('market')->insert([
            'price' => $cm_data->price,
            'volume_24h' => $cm_data->volume_24h,
            'volume_change_24h' => $cm_data->volume_change_24h,
            'percent_change_1h' => $cm_data->percent_change_1h,
            'percent_change_24h' => $cm_data->percent_change_24h,
            'percent_change_7d' => $cm_data->percent_change_7d,
            'percent_change_30d' => $cm_data->percent_change_30d,
            'percent_change_60d' => $cm_data->percent_change_60d,
            'percent_change_90d' => $cm_data->percent_change_90d,
            'market_cap' => $cm_data->market_cap,
            'market_cap_dominance' => $cm_data->market_cap_dominance,
            'fully_diluted_market_cap' => $cm_data->fully_diluted_market_cap,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        return true;
    }

    private function coinmarketcap() {
        $url = 'https://pro-api.coinmarketcap.com/v2/cryptocurrency/quotes/latest';
        $parameters = [
          'symbol' => 'ewt', // < EWT
          'convert' => 'USD'
        ];

        $headers = [
          'Accepts: application/json',
          'X-CMC_PRO_API_KEY: 450011a2-7e60-4761-8b6c-3923da0ce00e'
        ];
        $qs = http_build_query($parameters); // query string encode the parameters
        $request = "{$url}?{$qs}"; // create the request URL


        $curl = curl_init(); // Get cURL resource
        // Set cURL options
        curl_setopt_array($curl, array(
          CURLOPT_URL => $request,            // set the request URL
          CURLOPT_HTTPHEADER => $headers,     // set the headers
          CURLOPT_RETURNTRANSFER => 1         // ask for raw response instead of bool
        ));

        $response = curl_exec($curl); // Send the request, save the response
        return json_decode($response);
        curl_close($curl); // Close request
    }

}
