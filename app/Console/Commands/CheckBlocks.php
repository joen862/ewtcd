<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Web3\Web3;
use Web3\Providers\HttpProvider;
use Web3\RequestManagers\HttpRequestManager;
use App\Models\Block;
use App\Models\Wallet;
use App\Models\Transaction;

class CheckBlocks extends Command
{

    protected $signature = 'checkblocks';
    protected $description = 'Check EWC blocks for miners and transactions starting from the last checked blocks';

    public function handle() {

        $start_time = microtime(true);

        $this->info('Start tracking new blocks');

        // Fetch the lates block number from EWC
        $latest_onchain_blocknumber = $this->latestBlockNumber();

        // Fetch the highest block checked from DB
        $block = Block::max('block_number');
        $last_checked = $block->block_number;

        // Define which blocks to check
        $from_block = $last_checked+1;
        $to_block = $from_block+5000;

        // Loop through unchecked blocks
        for($i=$from_block; $i < $to_block; $i++) {

            $this->line("checking block #$i");

            // Fetch block data from EWC
            $block_data = $this->getBlockData($i);

            // check if the miner already exists, if not add it
            if(Wallet::where('address',$block_data->miner)->doesntExist()) {
                $miner = new Wallet;
                $miner->label = "Unknown miner";
                $miner->slug = substr($block_data->miner,0,6);
                $miner->category = "Miner";
                $miner->address = $block_data->miner;
                $miner->balance = $this->getBalance($block_data->miner);
                $miner->notes = "Automatically added by tracking block (#".hexdec($block_data->number).")";
                $miner->balance_last_update = date('Y-m-d H:i:s');
                $miner->token_allocation = 0;
                $miner->validator_id = 0;
                $miner->save();

                $this->info('miner added: '.$block_data->miner);

            } else {
                //dump('miner already exists');
            }

            // check if there are any transactions we need to store
            if(!empty($block_data->transactions)) {

                foreach($block_data->transactions as $transaction_data) {

                    $value = hexdec($transaction_data->value)/1000000000000000000;

                    if($value > 0) {
                        $tx = new Transaction;
                        $tx->hash = $transaction_data->hash;
                        $tx->blockNumber = hexdec($transaction_data->blockNumber);
                        $tx->from = $transaction_data->from;
                        $tx->to = $transaction_data->to;
                        $tx->value = $value;
                        //$tx->condition = $transaction_data->condition;
                        //$tx->creates = $transaction_data->creates;
                        $tx->gas = hexdec($transaction_data->gas);
                        $tx->gasPrice = hexdec($transaction_data->gasPrice);
                        $tx->input = $transaction_data->input;
                        $tx->nonce = hexdec($transaction_data->nonce);
                        //$tx->publicKey = $transaction_data->publicKey;
                        $tx->r = $transaction_data->r;
                        //$tx->raw = $transaction_data->raw;
                        $tx->s = $transaction_data->s;
                        $tx->standardV = isset($transaction_data->standardV) ? hexdec($transaction_data->standardV) : '';
                        $tx->transactionIndex = hexdec($transaction_data->transactionIndex);
                        $tx->type = hexdec($transaction_data->type);
                        $tx->blockHash = $transaction_data->blockHash;
                        $tx->v = hexdec($transaction_data->v);
                        //$tx->chainId = hexdec($transaction_data->chainId);

                        $tx->save();

                        $this->info('Transaction added: '.$transaction_data->hash);
                    }

                }
            }

            // update last checked block in DB
            $block->block_number = hexdec($block_data->number);
            $block->timestamp = date('Y-m-d H:i:s',hexdec($block_data->timestamp));
            $block->save();

            // Break in case we are at the latest block
            if($i == $latest_onchain_blocknumber) {
                $this->line('Reached current EWC block');
                break;
            }
        }

        $time_elapsed = microtime(true) - $start_time;

        $this->info('Done in '.$time_elapsed.' seconds. '.round(($to_block-$from_block)/$time_elapsed).' blocks per second');

        return Command::SUCCESS;
    }

    private function connectRPC() {
        $web3 = new Web3(new HttpProvider(new HttpRequestManager(env('JSON_RPC'))));
        return $web3->eth;
    }

    private function latestBlockNumber() {

        $eth = $this->connectRPC();

        $blocknumber = 0;
        $eth->blockNumber(function ($err, $data) use (&$blocknumber) {
            if($err !== null) {
                throw $err;
            }
            $blocknumber = $data;
        });

        return intval($blocknumber->value);

    }

    private function getBlockData($blocknumber = 'latest') {

        $eth = $this->connectRPC();

        $blockdata = 0;
        $eth->getBlockByNumber($blocknumber,true, function($err, $data) use(&$blockdata) {
            if($err !== null) {
                throw $err;
            }
            $blockdata = $data;
        });

        return $blockdata;

    }

    private function getBalance($address) {

        $eth = $this->connectRPC();

        $balance= 0;
        $eth->getBalance($address,function($err, $rawBalance) use(&$balance) {
            if($err !== null) {
                throw $err;
            }
            $balance = $rawBalance->value/1000000000000000000;
        });

        return $balance;

    }

}
