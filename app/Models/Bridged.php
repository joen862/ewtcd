<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use DB;

class Bridged extends Model
{
    use HasFactory;
    protected $table = 'bridged';

    public function updateBridgedData() {
        $decimals= 1000000000000000000;
        $ewtb_address = '0x178c820f862b14f316509ec36b13123da19a6054';
        $ewtb_data = json_decode($this->ethplorer('getTokenHistoryGrouped/'.$ewtb_address));

        $data['ewtb-total'] = json_decode($this->ethplorer('getTokenInfo/'.$ewtb_address))->totalSupply/$decimals;
        $data['ewtb-last-day'] = $ewtb_data->countTxs[0]->cnt;

        $data['ewtb-last-week'] = 0;

        for($i=0; $i < 7; $i++) {
            $data['ewtb-last-week'] = $data['ewtb-last-week'] + $ewtb_data->countTxs[$i]->cnt;
        }

        $data['ewtb-last-month'] = 0;

        for($i=0; $i < count($ewtb_data->countTxs); $i++) {
            $data['ewtb-last-month'] = $data['ewtb-last-month'] + $ewtb_data->countTxs[$i]->cnt;
        }

        DB::table('bridged')->insert([
            'minted' => $data['ewtb-total'],
            'tx_last_day' => $data['ewtb-last-day'],
            'tx_last_week' => $data['ewtb-last-week'],
            'tx_last_month' => $data['ewtb-last-month'],
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        return true;

    }

    private function ethplorer($query) {
        $api_key = 'EK-8dxmX-uiv5UAf-SyhAQ'; // << van Troll
        $data = Http::get('https://api.ethplorer.io/'.$query.'?apiKey='.$api_key);
        return $data->body();
    }

}
