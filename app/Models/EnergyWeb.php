<?php

namespace App\Models;

class EnergyWeb {

    public function getTotalStaked($address) {
        $totalStaked = $this->getStorageAt($address,6);
        return hexdec($totalStaked)/1000000000000000000;
    }

    public function getStorageAt($address, $position = 0) {
        $response = $this->jsonrpc('eth_getStorageAt',[
            $address,
            '0x'.dechex($position),
        ]);
        return($response);
    }

    public function getCode($address) {
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

    public function call($to,$value) {
        $response = $this->jsonrpc('eth_call',[[
            'to' => $to,
            'value' => $value,
        ]]);
        return $response;
    }

    public function getBalance($address) {
        $balance = $this->jsonrpc('eth_getBalance',[
            $address,
        ]);
        return hexdec($balance)/1000000000000000000;
    }

    public function blockNumber() {
        $block_number = $this->jsonrpc('eth_blockNumber');
        return hexdec($block_number);
    }

    public function jsonrpc($method = 'eth_blockNumber', $params = []) {

        $postfields = '{"method":"'.$method.'","params":'.json_encode($params).',"id":1,"jsonrpc":"2.0"}';
        //dump($postfields);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => env('JSON_RPC','https://rpc.energyweb.org/'),
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

