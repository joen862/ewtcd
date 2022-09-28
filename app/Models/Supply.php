<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use DB;

class Supply extends Model
{
    use HasFactory;
    protected $table = 'supply';

    public function updateSupplyData() {
        $total = Http::get('https://explorer.energyweb.org/api?module=stats&action=coinsupply')->body();
        $circulating = Http::get('https://supply.energyweb.org/')->body();

        DB::table('supply')->insert([
            'total_supply' => $total,
            'circulating_supply' => $circulating,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        return true;
    }

}
