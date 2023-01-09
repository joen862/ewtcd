<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use App\Models\Wallet;
use App\Models\Validator;
use App\Models\Transaction;
use App\Models\Block;
use App\Models\EnergyWeb;

class AddressController extends Controller {

    public function show($address = null) {

        if (!$this->isValidAddress($address)) {
            abort(404,"This page requires a valid 0x address");
        }

        $ewc = new EnergyWeb();
        $wallet = array();

        // Look up the address in the tracked wallets table
        if($wallet = Wallet::where('address',$address)->first()) {
            $wallet = $wallet->toArray();
        }

        // List all the addresses the wallet has sent EWT to
        $to_unique = Transaction::groupBy('to')
        ->where('from',$address)
        ->selectRaw('transactions.to, sum(value_decimal) as total_ewt, count(transactions.to) as count_tx, max(blockNumber) as latest_block, min(blockNumber) as first_block')
        ->limit(25)
        ->orderBy('total_ewt', 'desc')
        ->get()
        ->toArray();

        foreach($to_unique as $key => $to_address) {

            // Fetch tracked wallet if known
            if($to_wallet = Wallet::where('address',$to_address)->first()) {
                $to_unique[$key]['wallet']=$to_wallet->toArray();
            }

            // Fetch latest block date
            if($latest_date = Block::where('block_number',$to_address['latest_block'])->first()) {
                $date = $latest_date->toArray();
                $to_unique[$key]['latest_date'] = $date['timestamp'];
            } else {
                $to_unique[$key]['latest_date'] = $to_address['latest_block'];
            }

            // Fetch first block date
            if($first_date = Block::where('block_number',$to_address['first_block'])->first()) {
                $date = $first_date->toArray();
                $to_unique[$key]['first_date'] = $date['timestamp'];
            } else {
                $to_unique[$key]['first_date'] = $to_address['first_block'];
            }

        }

        // List all the addresses the wallet has received EWT from
        $from_unique = Transaction::groupBy('from')
        ->where('to',$address)
        ->selectRaw('transactions.from, sum(value_decimal) as total_ewt, count(transactions.from) as count_tx, max(blockNumber) as latest_block, min(blockNumber) as first_block')
        ->limit(25)
        ->orderBy('total_ewt', 'desc')
        ->get()
        ->toArray();

        foreach($from_unique as $key => $from_address) {

            // Fetch tracked wallet if known
            if($from_wallet = Wallet::where('address',$from_address)->first()) {
                $from_unique[$key]['wallet']=$from_wallet->toArray();
            }

            // Fetch latest block date
            if($latest_date = Block::where('block_number',$from_address['latest_block'])->first()) {
                $date = $latest_date->toArray();
                $from_unique[$key]['latest_date'] = $date['timestamp'];
            } else {
                $from_unique[$key]['latest_date'] = $from_address['latest_block'];
            }

            // Fetch first block date
            if($first_date = Block::where('block_number',$from_address['first_block'])->first()) {
                $date = $first_date->toArray();
                $from_unique[$key]['first_date'] = $date['timestamp'];
            } else {
                $from_unique[$key]['first_date'] = $from_address['first_block'];
            }

        }

        return view('address')
        ->with('address',$address)
        ->with('balance',$ewc->getBalance($address))
        ->with('wallet',$wallet)
        ->with('from',$from_unique)
        ->with('to',$to_unique);

    }

    function isValidAddress($address) {
        // Check if the input string is a valid hexadecimal string
        if (!preg_match('/^(0x)?[0-9a-fA-F]{40}$/', $address)) {
            return false;
        }

        // Check if the address is all zeros
        if (preg_match('/^(0x)?0{40}$/', $address)) {
            return false;
        }

        // Check if the address is all ones
        if (preg_match('/^(0x)?f{40}$/', $address)) {
            return false;
        }

        return true;
    }


}
