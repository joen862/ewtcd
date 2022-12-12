<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

use Web3\Web3;
use Web3\Providers\HttpProvider;
use Web3\RequestManagers\HttpRequestManager;

use App\Models\Block;
use App\Models\Wallet;
use App\Models\Transaction;

class RPCController extends Controller {

    public function index() {

        $pool_addr = "0x181A8b2a5AEb25941F6A79b4aE43dBb1968c417A";

        dump($this->blockNumber());
        //dump($this->getBalance($pool_addr));

        // still get VM execution error on this one:
        //dump($this->call($pool_addr,'0x817b1cd2'));

        // how to decode the hex response?
        //dump($this->getCode($pool_addr));

        //dump($this->getTotalStaked($pool_addr));

    }

    private function getTotalStaked($address) {
        $totalStaked = $this->getStorageAt($address,6);
        return hexdec($totalStaked)/1000000000000000000;
    }

    private function getStorageAt($address, $position = 0) {
        $response = $this->jsonrpc('eth_getStorageAt',[
            $address,
            '0x'.dechex($position),
        ]);
        return($response);
    }

    private function getCode($address) {
        // Found by trial and error from staking pool contract
        // 0 = claimManager
        // 1 = start
        // 2 = end
        // 3 = hourlyRatio
        // 4 = hardcap
        // 5 = contributionLimit
        // 6 = totalStaked
        // 7 = ??? patronRoles? 1
        // 8 = ??? ownerRole? 0
        // 9 = ??? remainingRewards? 542464.12112055
        // 10 = ??? futureRewards? 541818.48427605
        // 11 = ??? initiator?
        $response = $this->jsonrpc('eth_getCode',[
            $address,
        ]);
        return $response;
    }

    private function call($to,$value) {
        $response = $this->jsonrpc('eth_call',[[
            'to' => $to,
            'value' => $value,
        ]]);
        return $response;
    }

    private function getBalance($address) {
        $balance = $this->jsonrpc('eth_getBalance',[
            $address,
        ]);
        return hexdec($balance)/1000000000000000000;
    }

    private function blockNumber() {
        $block_number = $this->jsonrpc('eth_blockNumber');
        return hexdec($block_number);
    }

    private function jsonrpc($method = 'eth_blockNumber', $params = []) {

        $postfields = '{"method":"'.$method.'","params":'.json_encode($params).',"id":1,"jsonrpc":"2.0"}';
        dump($postfields);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://rpc.energyweb.org/",
            //CURLOPT_URL => "localhost:8545",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 5,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $postfields,
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/json",
            ),
        ));

        $response = json_decode(curl_exec($curl));
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } elseif(isset($response->error)) {
            return 'jsonrpc Error #'.$response->error->code.': ' . $response->error->message;
        } else {
            return $response->result;
        }
    }

}
