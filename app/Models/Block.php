<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Web3\Web3;
use Web3\Providers\HttpProvider;
use Web3\RequestManagers\HttpRequestManager;
use DB;

class Block extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'block';
    //protected $fillable = ['id','block','timestamp'];




    public function addNewBlocks() {

        // get the latest blocknumber from DB
        $latest_db_block = $this->orderBy('block','desc')->first();
        $latest_db_blocknumber = $latest_db_block->block;

        // Get the latest blocknumber from EWC
        $latest_onchain_blocknumber = $this->latestBlockNumber();
        $latest_onchain_block = $this->getBlockData($latest_onchain_blocknumber);

        if($latest_onchain_blocknumber > $latest_db_blocknumber) {
            $from_block = $latest_db_blocknumber+1;
            $to_block = $from_block+50;

            for($i=$from_block; $i <= $to_block; $i++) {

                $new_block = $this->getBlockData($i);

                $block = $this->firstOrCreate([
                    'block' => hexdec($new_block->number),
                    'timestamp' => date('Y-m-d H:i:s',hexdec($new_block->timestamp)),
                    'miner' => $new_block->miner,
                ]);

                //dump($block->block);

                if($i == $latest_onchain_blocknumber) {
                    break;
                }
            }
        }



    }

    private function connectRPC() {
        $web3 = new Web3(new HttpProvider(new HttpRequestManager("https://rpc.energyweb.org/")));
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
