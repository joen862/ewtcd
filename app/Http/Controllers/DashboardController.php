<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use App\Models\Wallet;
use App\Models\Market;
use App\Models\Supply;
use App\Models\Bridged;
use App\Models\Validator;

class DashboardController extends Controller {

    public function index() {

        // retrieve wallets and convert to easy usable array
        $wallets = Wallet::all()->toArray();

        foreach($wallets as $key => $wallet) {
            $wallets[$wallet['slug']] = $wallet;
            unset($wallets[$key]);
        }

        $market = new Market;
        $supply = new Supply;
        $bridged = new Bridged;

        // retrieve latest data
        $market_data = $market->latest()->first();
        $supply_data = $supply->latest()->first();
        $bridged_data = $bridged->latest()->first();

        // If data is empty make sure it is updated
        if(empty($market_data)) {
            $market->updateMarketData();
            $market_data = $market->latest()->first();
        }

        if(empty($supply_data)) {
            $supply->updateSupplyData();
            $supply_data = $supply->latest()->first();
        }

        if(empty($bridged_data)) {
            $bridged->updateBridgedData();
            $bridged_data = $bridged->latest()->first();
        }

        // get wallet category sums
        $data['total-staked'] = $this->sumOfCategory('Staking',$wallets);
        $data['founder2-total'] = $this->sumOfCategory('Founder2',$wallets);
        $data['rounda-total'] = $this->sumOfCategory('Round A Affiliates',$wallets);
        $data['roundbc-total'] = $this->sumOfCategory('Round B/C Affiliates',$wallets);
        $data['total-exchanges'] = $this->sumOfCategory('Exchanges',$wallets);

        // get miner counts
        $data['active-miners-count'] = Wallet::where('category','Miner')->whereRelation('Validator','active',true)->count();
        $data['inactive-miners-count']= Wallet::where('category','Miner')->whereRelation('Validator','active',false)->count();
        $data['unknown-miners-count']= Wallet::where('category','Miner')->doesntHave('Validator')->count();

        // get miner holdings
        $data['active-miners-holding'] = Wallet::where('category','Miner')->whereRelation('Validator','active',true)->sum('balance');
        $data['inactive-miners-holding']= Wallet::where('category','Miner')->whereRelation('Validator','active',false)->sum('balance');
        $data['unknown-miners-holding']= Wallet::where('category','Miner')->doesntHave('Validator')->sum('balance');

        // get validator counts
        $data['active-validators-count'] = Validator::where('active',true)->count();
        $data['inactive-validators-count'] = Validator::where('active',false)->count();;

        // get/calculate other metrics
        $data['total'] = $supply_data->total_supply;
        $data['circulating-supply'] = $supply_data->circulating_supply;
        $data['crc-staked'] = 6868845550865303576675966/1000000000000000000;
        $data['crc-rewards'] = $wallets['crc']['balance']-$data['crc-staked'];
        $data['crc-max-rewards'] = 578238; // [your amount]*((10,36/100+1)^(275/365)-1) << doesn't work in PHP, it does in Excel

        // set bridged data
        $data['ewtb-total'] = $bridged_data->minted;
        $data['ewtb-last-day'] = $bridged_data->tx_last_day;
        $data['ewtb-last-week'] = $bridged_data->tx_last_week;
        $data['ewtb-last-month'] = $bridged_data->tx_last_month;

        return view('dashboard')
            ->with('data',$data)
            ->with('wallets',$wallets)
            ->with('market',$market_data);
    }

    public function wallets() {

        // retrieve wallets and convert to easy usable array
        $wallets = Wallet::all()->toArray();

        foreach($wallets as $key => $wallet) {
            $wallets[$wallet['slug']] = $wallet;
            unset($wallets[$key]);
        }

        return view('wallets')
            ->with('wallets',$wallets);
    }

    public function validators() {


        return view('validators');
    }


    private function sumOfCategory($category,$wallets) {
        $sum = 0;
        foreach($wallets as $wallet) {
            if($wallet['category'] == $category) {
                $sum = $sum+$wallet['balance'];
            }
        }
        return $sum;
    }

    private function countOfCategory($category,$wallets) {
        $count = 0;
        foreach($wallets as $wallet) {
            if($wallet['category'] == $category) {
                $count++;
            }
        }
        return $count;
    }

    private function ethplorer($query) {
        $api_key = env("ETHPlorer_key");
        $data = Http::get('https://api.ethplorer.io/'.$query.'?apiKey='.$api_key);
        return $data->body();

    }

    private function explorer($query) {

        foreach($query as $key => $value) {
            $query_string[]= $key.'='.$value;
        }

        $query_string = implode('&',$query_string);

        $data = Http::get('https://explorer.energyweb.org/api?'.$query_string);

        return $data->body();
    }

}
