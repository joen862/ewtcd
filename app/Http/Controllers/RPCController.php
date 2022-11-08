<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Web3\Web3;
use Web3\Providers\HttpProvider;
use Web3\RequestManagers\HttpRequestManager;
use App\Models\Block;
use App\Models\Wallet;
use App\Models\Transaction;

class RPCController extends Controller {

    public function index() {

        $params = [
            [
                'to' => '0x181A8b2a5AEb25941F6A79b4aE43dBb1968c417A',
                //'data' => '0x817b1cd2', // totalStaked
                'data' => '0xfb86a404', // hardCap
            ],
            'latest'
        ];

        //dump(hex2bin('37353030303030303030303030303030303030303030303030'));

        dump(json_encode($params));

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://rpc.energyweb.org/");
        //curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
        //curl_setopt($ch, CURLOPT_USERPWD, "user" . ":" . "pass");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, '{"jsonrpc":"2.0","method":"eth_call","params":'.json_encode($params).',"id":1}');
        //curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        //curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($ch);
        if(curl_errno($ch)) {
            dump('Error: '.curl_error($ch));
        }

        curl_close($ch);
        dump(hex2bin('00000000000000000000000000000000000000000006342fd08f00f637800000'));

        /*
        $eth = $this->connectRPC();

        $params = [
            'to' => '0x181A8b2a5AEb25941F6A79b4aE43dBb1968c417A',
            //'data' => 'totalStaked',
        ];

        $eth->call(['sdf','sdf'],'latest',function($err,$data) {
            if($err !== null) {
                throw $err;
            }
            dd($data);
        });

        //$eth->getStorageAt('0x181A8b2a5AEb25941F6A79b4aE43dBb1968c417A', function($err,$data) {
            // do something
        //});
        */

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

}
