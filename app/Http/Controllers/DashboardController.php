<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use App\Models\Wallet;
use App\Models\Market;
use App\Models\Supply;
use App\Models\Bridged;

class DashboardController extends Controller {

    public function index() {

        // retrieve wallets and convert to easy usable array
        $wallets = Wallet::all()->toArray();

        foreach($wallets as $key => $wallet) {
            $wallets[$wallet['slug']] = $wallet;
            unset($wallets[$key]);
        }

        // retrieve latest data
        $market = Market::latest()->first();
        $supply = Supply::latest()->first();
        $bridged = Bridged::latest()->first();

        // get wallet category sums
        $data['total-staked'] = $this->sumOfCategory('Staking',$wallets);
        $data['founder2-total'] = $this->sumOfCategory('Founder2',$wallets);
        $data['rounda-total'] = $this->sumOfCategory('Round A Affiliates',$wallets);
        $data['roundbc-total'] = $this->sumOfCategory('Round B/C Affiliates',$wallets);
        $data['active-validators'] = $this->sumOfCategory('Active Validators',$wallets);
        $data['inactive-validators'] = $this->sumOfCategory('Inactive Validators',$wallets);
        $data['total-exchanges'] = $this->sumOfCategory('Exchanges',$wallets);

        // get/calculate other metrics
        $data['total'] = $supply->total_supply;
        $data['circulating-supply'] = $supply->circulating_supply;
        $data['crc-staked'] = 6868845550865303576675966/1000000000000000000;
        $data['crc-rewards'] = $wallets['crc']['balance']-$data['crc-staked'];
        $data['crc-max-rewards'] = 578238; // [your amount]*((10,36/100+1)^(275/365)-1) << doesn't work in PHP, it does in Excel

        // set bridged data
        $data['ewtb-total'] = $bridged->minted;
        $data['ewtb-last-day'] = $bridged->tx_last_day;
        $data['ewtb-last-week'] = $bridged->tx_last_week;
        $data['ewtb-last-month'] = $bridged->tx_last_month;

        return view('dashboard')
            ->with('data',$data)
            ->with('wallets',$wallets)
            ->with('market',$market);
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

    /*public $wallets = [
        'team' => [
            'label' => 'Team (EWF Endowment)',
            'category' => 'Team',
            'address' => '0x120470000000000000000000000000000000000a',
        ],
        'community' => [
            'label' => 'Community Fund',
            'category' => 'Community',
            'address' => '0x1204700000000000000000000000000000000003',
        ],
        'founder1' => [
            'label' => 'Founder 1',
            'category' => 'Founders',
            'address' => '0x69aF0912dd44dce2B2373dB4021788CbAd84Ff35',
            'balance' => '5000000',
            'note' => "Balance manually overwritten because this wallet hasn't claimed 5m tokens from the distribution contract yet."
        ],
        'founder2' => [
            'label' => 'Founder 2',
            'category' => 'Founders',
            'address' => '0xb561618a3Ea959a5E363643B267C4CB8fe4B1DF7',
            'note' => 'Balance in the overview is the sum of its original wallet + the 10 new wallets. '
        ],
        'founder2-1' => [
            'label' => 'Founder 2 wallet #1',
            'category' => 'Founder2',
            'address' => '0x410aCA87630bC74E32113f4d19C8853362103255',
        ],
        'founder2-2' => [
            'label' => 'Founder 2 wallet #2',
            'category' => 'Founder2',
            'address' => '0x7D1AE9AEef3ed42f3DB4E6b29C82379F6eb6095b',
        ],
        'founder2-3' => [
            'label' => 'Founder 2 wallet #3',
            'category' => 'Founder2',
            'address' => '0x699a66B6EC95db389C685F07Eee08E09ADfCD541',
        ],
        'founder2-4' => [
            'label' => 'Founder 2 wallet #4',
            'category' => 'Founder2',
            'address' => '0x2af2E09A69f3C79E6d357cfa67028C7fb10DEe7c',
        ],
        'founder2-5' => [
            'label' => 'Founder 2 wallet #5',
            'category' => 'Founder2',
            'address' => '0x90eA07EC516f5957b5dd6251FB1B65C7bC7eC4b4',
        ],
        'founder2-6' => [
            'label' => 'Founder 2 wallet #6',
            'category' => 'Founder2',
            'address' => '0x6523b3cFd89D20924117b1D659c6d82417d7e36a',
        ],
        'founder2-7' => [
            'label' => 'Founder 2 wallet #7',
            'category' => 'Founder2',
            'address' => '0xEA097e845bE2Fb4f37aF292EEdad6bfDA7dE5047',
        ],
        'founder2-8' => [
            'label' => 'Founder 2 wallet #8',
            'category' => 'Founder2',
            'address' => '0x0966962952fdFfB57C814BaD395B4bd001CF12b9',
        ],
        'founder2-9' => [
            'label' => 'Founder 2 wallet #9',
            'category' => 'Founder2',
            'address' => '0x1D1A606c4a8459CB531080313191c1Ea4e6cF94A',
        ],
        'founder2-10' => [
            'label' => 'Founder 2 wallet #10',
            'category' => 'Founder2',
            'address' => '0x87ef0070ea79da428d5b3428dCF13088536Fe771',
        ],
        'round_a1' => [
            'label' => 'Round A Affiliate #1',
            'category' => 'Round A Affiliates',
            'address' => '0xb561618a3Ea959a5E363643B267C4CB8fe4B1DF7',
        ],
        'round_a2' => [
            'label' => 'Round A Affiliate #2',
            'category' => 'Round A Affiliates',
            'address' => '0x06920Bb91F7027176Cf373996D39B539ba436D87',
        ],
        'round_a3' => [
            'label' => 'Round A Affiliate #3',
            'category' => 'Round A Affiliates',
            'address' => '0x3f11B4ad17FdE4695CAd64E109AE92a679d87Bfc',
        ],
        'round_a4' => [
            'label' => 'Round A Affiliate #4',
            'category' => 'Round A Affiliates',
            'address' => '0x47428fc08e56388372e7C81Ad4A1140d932d1096',
        ],
        'round_a5' => [
            'label' => 'Round A Affiliate #5',
            'category' => 'Round A Affiliates',
            'address' => '0x7030892dbF9c2048E796296dDA597F145754a185',
        ],
        'round_a6' => [
            'label' => 'Round A Affiliate #6',
            'category' => 'Round A Affiliates',
            'address' => '0x8c994AdA51d35B8519424368807fb99C10336686',
        ],
        'round_a7' => [
            'label' => 'Round A Affiliate #7',
            'category' => 'Round A Affiliates',
            'address' => '0xDe6B493D368316b9078454e37DCE4968482Dfbe9',
        ],
        'kraken' => [
            'label' => 'Kraken',
            'category' => 'Exchanges',
            'address' => '0x7136255E5758397506C360625961cc0de6956027',
        ],
        'kucoin-hot' => [
            'label' => 'Kucoin (hot wallet)',
            'category' => 'Exchanges',
            'address' => '0xB0a384fAe14fa7A66Cc7Dd52e079ca2264A05b00',
        ],
        'kucoin-cold' => [
            'label' => 'Kucoin (cold wallet)',
            'category' => 'Exchanges',
            'address' => '0xD6216fC19DB775Df9774a6E33526131dA7D19a2c',
        ],
        'gate' => [
            'label' => 'Gate.io',
            'category' => 'Exchanges',
            'address' => '0x0D0707963952f2fBA59dD06f2b425ace40b492Fe',
        ],
        'hotbit' => [
            'label' => 'HotBit',
            'category' => 'Exchanges',
            'address' => '0xA3C8Ae0772Cf6AF0295131B2E83C79ba3C5A6e58',
        ],
        'liquid' => [
            'label' => 'Liquid',
            'category' => 'Exchanges',
            'address' => '0x07EA3141809F21e19D2d41c8EC5A1244C247FA0f',
        ],
        'booster' => [
            'label' => 'Booster Pool',
            'category' => 'Staking',
            'address' => '0x3Bd4D48D022ACA4C3FC1Fe673CF4741D5888bcc7',
        ],
        'eea' => [
            'label' => 'Engie Energy Access',
            'category' => 'Staking',
            'address' => '0x8df330b8966ebE69Be996653e50252c6D44a527a',
        ],
        'crc' => [
            'label' => 'CRC Pool incl Rewards',
            'category' => 'Staking',
            'address' => '0x181A8b2a5AEb25941F6A79b4aE43dBb1968c417A',
        ],
        [
            'label' => '3Degrees',
            'category' => 'Active Validators',
            'address' => '0xA0827857FA91A9B4D720268B61B2DC96BAA019FA',
        ],
        [
            'label' => 'Bloxmove',
            'category' => 'Active Validators',
            'address' => '0x9430A215FFCA453252137908CAACD504C224E66D',
        ],
        [
            'label' => 'Acciona',
            'category' => 'Active Validators',
            'address' => '0xC77B908353E648C3C08A9071E9129EA9FCDA4E23',
        ],
        [
            'label' => 'AES',
            'category' => 'Active Validators',
            'address' => '0x87449AA1412E34F0450CC5AA795200E05B050AE1',
        ],
        [
            'label' => 'Allgäuer Überlandwerk',
            'category' => 'Active Validators',
            'address' => '0xF8EB4F3B9C179A5E0F76BC1A7A8B15A5B74996D9',
        ],
        [
            'label' => 'AnyBlock Analytics',
            'category' => 'Active Validators',
            'address' => '0xB1DD5415DFA3E82E63AF394E48F0D4D8E686425D',
        ],
        [
            'label' => 'ASA Automation',
            'category' => 'Active Validators',
            'address' => '0x9C562C804AEDF1B506B61E45C83A789BF207B08B',
        ],
        [
            'label' => 'Austin Consultants',
            'category' => 'Active Validators',
            'address' => '0x177E147E5552903629CCE2E42361EDD899EC7978',
        ],
        [
            'label' => 'Blok-Z',
            'category' => 'Active Validators',
            'address' => '0xC0C32DCF53C2DDD97087EE0042729705B2E6CC25',
        ],
        [
            'label' => 'Deutsche ErdWarme',
            'category' => 'Active Validators',
            'address' => '0x874008D366995B5AEF76A5126D8A5F1AE934AB80',
        ],
        [
            'label' => 'E-regio',
            'category' => 'Active Validators',
            'address' => '0xB920432447E50F21EBDEAA6E5431A8E91DD991D8',
        ],
        [
            'label' => 'EDF',
            'category' => 'Active Validators',
            'address' => '0x9E88DD25B6236E625709CA2830DEE8D0C70BDA7D',
        ],
        [
            'label' => 'Electra Caldense',
            'category' => 'Active Validators',
            'address' => '0x5831D2FBBF925C5131C75A2197E73C416C966A59',
        ],
        [
            'label' => 'Electric Blue Trading',
            'category' => 'Active Validators',
            'address' => '0x44BAC1E2A2F6B44F71C5BFA8CFDCBEB73DAC859B',
        ],
        [
            'label' => 'Elia Group',
            'category' => 'Active Validators',
            'address' => '0x63BE1C775237F4C02F94396A7A7837D6C9B14424',
        ],
        [
            'label' => 'Elocity',
            'category' => 'Active Validators',
            'address' => '0xA93C0D81BA7CD8A0C41016F09D02AA385586B23A',
        ],
        [
            'label' => 'Enerjisa Enerji',
            'category' => 'Active Validators',
            'address' => '0xAD6F905F533970F591DF630670007E0C5315668D',
        ],
        [
            'label' => 'Engie',
            'category' => 'Active Validators',
            'address' => '0x319736D0E5E921DF081E50CB36C7B4BA3642A651',
        ],
        [
            'label' => 'Evolugen',
            'category' => 'Active Validators',
            'address' => '0xA11214FDBCE59E256B859EF0BE2481ACFD98A314',
        ],
        [
            'label' => 'EWF',
            'category' => 'Active Validators',
            'address' => '0xD65B4C25A4CE1E024FF13425DF1E0E574A1A0E9B',
        ],
        [
            'label' => 'FlexiDAO',
            'category' => 'Active Validators',
            'address' => '0x045DF4EA79B1F17E451B9EB5E153DB8AE95FE79C',
        ],
        [
            'label' => 'Fluvius',
            'category' => 'Active Validators',
            'address' => '0xF37D30F8325771450C2EE1EB5B38BF4CC6E4338B',
        ],
        [
            'label' => 'FOTON',
            'category' => 'Active Validators',
            'address' => '0x8AFD93BF5BD9446C7A2070BA0B151F3F1CF1FF30',
        ],
        [
            'label' => 'Green Running',
            'category' => 'Active Validators',
            'address' => '0xC56B672AFD3FAE873BF8A40BBE80F51075B187CA',
        ],
        [
            'label' => 'Inavitas',
            'category' => 'Active Validators',
            'address' => '0x904E3EAB954EB80DABD5435DB4BCC7413863C28A',
        ],
        [
            'label' => 'LO3',
            'category' => 'Active Validators',
            'address' => '0xD28A4659DF172152CF3812DEC96EDDAA99A38C42',
        ],
        [
            'label' => 'Mercados Electricos',
            'category' => 'Active Validators',
            'address' => '0xB5DA81B0C1C808EF6D761DACFBA725BFE7BDF0B8',
        ],
        [
            'label' => 'Nethermind',
            'category' => 'Active Validators',
            'address' => '0x46D8BCDB927E20A56B33BBD0DA75E32B540AF9F9',
        ],
        [
            'label' => 'Oli Systems',
            'category' => 'Active Validators',
            'address' => '0x86A5A44CFF58638784C2028E7181CEDE57933321',
        ],
        [
            'label' => 'PTT Plc',
            'category' => 'Active Validators',
            'address' => '0xDAD22897407D4F5E93E5D8B49B19ABEBA4B4BD89',
        ],
        [
            'label' => 'SB Energy',
            'category' => 'Active Validators',
            'address' => '0x10B598DAD5DDD32B85A1B8F4365615D6BDC42A78',
        ],
        [
            'label' => 'Scytale Ventures',
            'category' => 'Active Validators',
            'address' => '0xFB7720716B3B2FA8940E3F46B7C53843718BF813',
        ],
        [
            'label' => 'South Pole',
            'category' => 'Active Validators',
            'address' => '0x9CD949E2CE9F1408DEE663318F5281C5ED94E534',
        ],
        [
            'label' => 'SPG',
            'category' => 'Active Validators',
            'address' => '0xF02BA87B74453A54D5EBB5A048CBACB90046CDD9',
        ],
        [
            'label' => 'Stedin',
            'category' => 'Active Validators',
            'address' => '0x25B02276431D29E481878140A0DB68A8A1350212',
        ],
        [
            'label' => 'Tenaska Power Services',
            'category' => 'Active Validators',
            'address' => '0x46495E58BC75CD44A8EC6EE6200A6035EF0332A0',
        ],
        [
            'label' => 'TWL',
            'category' => 'Active Validators',
            'address' => '0x54809EA74BECDD734D2C4329729835AB39BB23F3',
        ],
        [
            'label' => 'UTE',
            'category' => 'Active Validators',
            'address' => '0x936FB33641B1E7DFE277D40C0C38621C8DCC4357',
        ],
        [
            'label' => 'Vodafone',
            'category' => 'Active Validators',
            'address' => '0x292DADA7A8CF9603E8DDFBD5BF2E580818A5AB76',
        ],
        [
            'label' => 'Wirepas',
            'category' => 'Active Validators',
            'address' => '0x6C87141BE1105C37B8B27DAA25975C1575C22FD5',
        ],
        [
            'label' => 'Zytech',
            'category' => 'Active Validators',
            'address' => '0x4C8FC2CAD90BEE5332E887D3C9184424E76B11E0',
        ],
        [
            'label' => 'AnyBlock Analytics',
            'category' => 'Active Validators',
            'address' => '0xB1DD5415DFA3E82E63AF394E48F0D4D8E686425D',
        ],
        [
            'label' => 'Unknown 2',
            'category' => 'Active Validators',
            'address' => '0x73455eAc3304742695527D2AD455c8eE890c4473',
        ],
        [
            'label' => 'Unknown 3',
            'category' => 'Active Validators',
            'address' => '0x3975B79cA5f14757D0613B4AfE3694EC147A7167',
        ],
        [
            'label' => 'Unknown 4',
            'category' => 'Active Validators',
            'address' => '0x4813E2b291c373bF7a8590B695B0A77f43D765d6',
        ],
        [
            'label' => 'Unknown 5',
            'category' => 'Active Validators',
            'address' => '0xBc11295936Aa79d594139de1B2e12629414F3BDB',
        ],
        [
            'label' => 'Unknown 6',
            'category' => 'Active Validators',
            'address' => '0xABCae6fe36b82DFaEb8F4A21eab4aC67454E2a3D',
        ],
        [
            'label' => 'Unknown 7',
            'category' => 'Active Validators',
            'address' => '0x06920Bb91F7027176Cf373996D39B539ba436D87',
        ],
        [
            'label' => 'Unknown 8',
            'category' => 'Active Validators',
            'address' => '0xC32E395d5DC1dDf2eE8390f53DB8b5Ee3fdc1043',
        ],
        [
            'label' => 'Unknown 9',
            'category' => 'Active Validators',
            'address' => '0x41fcf95a80cA2B6E95B3AF33029FC83DE309823b',
        ],
        [
            'label' => 'Unknown 10',
            'category' => 'Active Validators',
            'address' => '0x815E18cD4238568E70edeFeBDa45696b07134Eb6',
        ],
        [
            'label' => 'Unknown 11',
            'category' => 'Active Validators',
            'address' => '0xB045E809005E4a5fa405659c39fb9a6af6Bebbe2',
        ],
        [
            'label' => 'Unknown 12',
            'category' => 'Active Validators',
            'address' => '0xe595048f2C467a3123C4BCDE597962467Fb13DA6',
        ],
        [
            'label' => 'Community Electricity',
            'category' => 'Inactive Validators',
            'address' => '0xD7DECCDC1CF5DFD34DF8A03135162D7F294FEDB0',
        ],
        [
            'label' => 'Unknown',
            'category' => 'Inactive Validators',
            'address' => '0x9f0f002b674312fb729e86bce5bb588fd7a5d672',
        ],
        [
            'label' => 'Unknown',
            'category' => 'Inactive Validators',
            'address' => '0xbC04309D494B97a562Be67A4A86B28Bc0c583C10',
        ],
        [
            'label' => 'Unknown Round B/C Affiliate',
            'category' => 'Round B/C Affiliates',
            'address' => '0xcfE7964b0b6412b013Dc019bDF3AfEf58be56593',
        ],
        [
            'label' => 'Unknown Round B/C Affiliate',
            'category' => 'Round B/C Affiliates',
            'address' => '0xfD7A30D3C2bD017A458610274C275059D308b2E7',
        ],
        [
            'label' => 'Unknown Round B/C Affiliate',
            'category' => 'Round B/C Affiliates',
            'address' => '0x871ba4266793aD11dA537D4857dE7Ad49EaB662b',
        ],
        [
            'label' => 'Unknown Round B/C Affiliate',
            'category' => 'Round B/C Affiliates',
            'address' => '0xb61C11B6E42d459EFAEe8995c44DB08507e468E1',
        ],
        [
            'label' => 'Unknown Round B/C Affiliate',
            'category' => 'Round B/C Affiliates',
            'address' => '0x656E5569BeF7781bf0Db199D32027766053501ff',
        ],
        [
            'label' => 'Unknown Round B/C Affiliate',
            'category' => 'Round B/C Affiliates',
            'address' => '0x1153818a2EB49F0a71B27313C32814fc02E4Db50',
        ],
        [
            'label' => 'Unknown Round B/C Affiliate',
            'category' => 'Round B/C Affiliates',
            'address' => '0x6Dd10e41A7a84FE23ab35feFa2F46C9895F87a2D',
        ],
        [
            'label' => 'Unknown Round B/C Affiliate',
            'category' => 'Round B/C Affiliates',
            'address' => '0x15696134ebeed360dc90DC97dDD00bd07e1C11e9',
        ],
        [
            'label' => 'Unknown Round B/C Affiliate',
            'category' => 'Round B/C Affiliates',
            'address' => '0x349ebc5a6e853df121c84E999081e5992928e64F',
        ],
        [
            'label' => 'Unknown Round B/C Affiliate',
            'category' => 'Round B/C Affiliates',
            'address' => '0x3A9d83766c03c465851a38DaA364ef7DEccd1ECE',
        ],
        [
            'label' => 'Unknown Round B/C Affiliate',
            'category' => 'Round B/C Affiliates',
            'address' => '0x3C9f867D9b3a595987E198786FA9aB722E5C2F9b',
        ],
        [
            'label' => 'Unknown Round B/C Affiliate',
            'category' => 'Round B/C Affiliates',
            'address' => '0x4d0aA1c3459BF41e3Ad4E4F40Bbf029Cb5723d83',
        ],
        [
            'label' => 'Unknown Round B/C Affiliate',
            'category' => 'Round B/C Affiliates',
            'address' => '0x6a0A5dA2a48ea87C2A906C53b3373642c29a4b6C',
        ],
        [
            'label' => 'Unknown Round B/C Affiliate',
            'category' => 'Round B/C Affiliates',
            'address' => '0x96A5eb172EfdF262Ed6beaaF0E20C6Af71831Fc9',
        ],
        [
            'label' => 'Unknown Round B/C Affiliate',
            'category' => 'Round B/C Affiliates',
            'address' => '0xBe4888C5b021E5F16cd254DE2D4EAF17625685C4',
        ],
        [
            'label' => 'Unknown Round B/C Affiliate',
            'category' => 'Round B/C Affiliates',
            'address' => '0xc1d441a2aD43Af7b4A3d8E3200d2cEB3A973099D',
        ],
        [
            'label' => 'Unknown Round B/C Affiliate',
            'category' => 'Round B/C Affiliates',
            'address' => '0xE23c7cB60189BB2FD60625d2C2747B1e68f10776',
        ],
        [
            'label' => 'Unknown Round B/C Affiliate',
            'category' => 'Round B/C Affiliates',
            'address' => '0x002D4606B65c033769968bCdc63881b90B0853f5',
        ],
        [
            'label' => 'Unknown Round B/C Affiliate',
            'category' => 'Round B/C Affiliates',
            'address' => '0x6D516767E4068FC331BDb331fba7578BDb07a68c',
        ],
        [
            'label' => 'Unknown Round B/C Affiliate',
            'category' => 'Round B/C Affiliates',
            'address' => '0x1f0c30B1aA4C468B5Beb02BaC8DF8F27617a2296',
        ],
        [
            'label' => 'Unknown Round B/C Affiliate',
            'category' => 'Round B/C Affiliates',
            'address' => '0xD44FB8De580D34F44789408cC9335c9A9cE0cE4d',
        ],
        [
            'label' => 'Unknown Round B/C Affiliate',
            'category' => 'Round B/C Affiliates',
            'address' => '0x25Ae7b45D8646580dfcAE403D29164729eB8642f',
        ],
        [
            'label' => 'Unknown Round B/C Affiliate',
            'category' => 'Round B/C Affiliates',
            'address' => '0x664f991cDb2ffe6b6A568edE65b0208DBCCE6f72',
        ],
        [
            'label' => 'Unknown Round B/C Affiliate',
            'category' => 'Round B/C Affiliates',
            'address' => '0xA720A8EE90f5013cAe9BF7BCac1d153E42815454',
        ],
        [
            'label' => 'Unknown Round B/C Affiliate',
            'category' => 'Round B/C Affiliates',
            'address' => '0xDb6cc57168c07b83a00f1f8871538446068824fC',
        ],
        [
            'label' => 'Unknown Round B/C Affiliate',
            'category' => 'Round B/C Affiliates',
            'address' => '0xe6E8A111C89B05337049dE9349C7C4880a396EF1',
        ],
        [
            'label' => 'Unknown Round B/C Affiliate',
            'category' => 'Round B/C Affiliates',
            'address' => '0xFfCf98C62c1BAd480aB6846717B173A72e2dD090',
        ],
        [
            'label' => 'Unknown Round B/C Affiliate',
            'category' => 'Round B/C Affiliates',
            'address' => '0xb999004B49C6b907D4278067DA5c85195DCD7Fc7',
        ],
        [
            'label' => 'Unknown Round B/C Affiliate',
            'category' => 'Round B/C Affiliates',
            'address' => '0xf4e31018A926F64CB780cB9f5f027377bCfb26fC',
        ],
        [
            'label' => 'Unknown Round B/C Affiliate',
            'category' => 'Round B/C Affiliates',
            'address' => '0x5fBb9c482034D287c5B3848Fc2F9272abdD5Bfa2',
        ],
        [
            'label' => 'Unknown Round B/C Affiliate',
            'category' => 'Round B/C Affiliates',
            'address' => '0x880E8b0ecE0171EDd0247f8d13D348d77A6b9b29',
        ],
        [
            'label' => 'Unknown Round B/C Affiliate',
            'category' => 'Round B/C Affiliates',
            'address' => '0xA69DCa0814EAadC89B6dBE94c5e2110497690f6C',
        ],
        [
            'label' => 'Unknown Round B/C Affiliate',
            'category' => 'Round B/C Affiliates',
            'address' => '0xC58A20e290E858542D8e8bb07b600aeb9195fe30',
        ],
        [
            'label' => 'Unknown Round B/C Affiliate',
            'category' => 'Round B/C Affiliates',
            'address' => '0x404Bb9c13364522133B363d5C4Adb7a88056B19d',
        ],
        [
            'label' => 'Unknown Round B/C Affiliate',
            'category' => 'Round B/C Affiliates',
            'address' => '0x00C2F65230815D30EaA1A4d057bCF0B72FE3cc4e',
        ],
        [
            'label' => 'Unknown Round B/C Affiliate',
            'category' => 'Round B/C Affiliates',
            'address' => '0x03CccDC799d4DC37d56E3f9DBa7f9c210fa1086f',
        ],
        [
            'label' => 'Unknown Round B/C Affiliate',
            'category' => 'Round B/C Affiliates',
            'address' => '0x047D955877a55Fbdac768573a9259f29B103a066',
        ],
        [
            'label' => 'Unknown Round B/C Affiliate',
            'category' => 'Round B/C Affiliates',
            'address' => '0x0ad7Ba4aF33B485e6F2505c417554631a3e5643f',
        ],
        [
            'label' => 'Unknown Round B/C Affiliate',
            'category' => 'Round B/C Affiliates',
            'address' => '0x3AbAA3f24428d6028F5A7FC5b18ce9D04cCec229',
        ],
        [
            'label' => 'Unknown Round B/C Affiliate',
            'category' => 'Round B/C Affiliates',
            'address' => '0x428aB4B019EE3a9B9863B2B4Bf1885CE6dff9a73',
        ],
        [
            'label' => 'Unknown Round B/C Affiliate',
            'category' => 'Round B/C Affiliates',
            'address' => '0x48Ee57fAf61c0b963113e7921e6173629e6bc443',
        ],
        [
            'label' => 'Unknown Round B/C Affiliate',
            'category' => 'Round B/C Affiliates',
            'address' => '0x57f33EfaD76D4B783cf42c9e6Cb08f4425dfe96e',
        ],
        [
            'label' => 'Unknown Round B/C Affiliate',
            'category' => 'Round B/C Affiliates',
            'address' => '0x7ed62CF71D519d3Bf293ef90829508F92F4CCCcb',
        ],
        [
            'label' => 'Unknown Round B/C Affiliate',
            'category' => 'Round B/C Affiliates',
            'address' => '0x9196e46D664CEDa55CB45a2CC5ab5Bd1b7e614E2',
        ],
        [
            'label' => 'Unknown Round B/C Affiliate',
            'category' => 'Round B/C Affiliates',
            'address' => '0x943c85B13f24083Ec73815f7Ba763B7c42Ae0288',
        ],
        [
            'label' => 'Unknown Round B/C Affiliate',
            'category' => 'Round B/C Affiliates',
            'address' => '0x9467B762550673F08B14423F8562048d5E369422',
        ],
        [
            'label' => 'Unknown Round B/C Affiliate',
            'category' => 'Round B/C Affiliates',
            'address' => '0xB476Ee7D610DAe7B23B671EBC7Bd6112E9772969',
        ],
        [
            'label' => 'Unknown Round B/C Affiliate',
            'category' => 'Round B/C Affiliates',
            'address' => '0xdAcD80D8e1d4f117515CAA477eE7599cDfc76619',
        ],
        [
            'label' => 'Unknown Round B/C Affiliate',
            'category' => 'Round B/C Affiliates',
            'address' => '0xFFd9b871dF6e93803C0877E98fC1722B39c00d78',
        ],
        [
            'label' => 'Unknown Round B/C Affiliate',
            'category' => 'Round B/C Affiliates',
            'address' => '0x006e371C454a2d081f3966c180Ba2C6165d87DE6',
        ],
        [
            'label' => 'Unknown Round B/C Affiliate',
            'category' => 'Round B/C Affiliates',
            'address' => '0x06FdB93aa64F33A8fb40a36c462a3f7A074D632C',
        ],
        [
            'label' => 'Unknown Round B/C Affiliate',
            'category' => 'Round B/C Affiliates',
            'address' => '0x0dd959deB4C458cc2aC379898Bf2c99f7A8F399B',
        ],
        [
            'label' => 'Unknown Round B/C Affiliate',
            'category' => 'Round B/C Affiliates',
            'address' => '0x2540dED041b6FEdC0Ff6F0CF26b891Ec97C95400',
        ],
        [
            'label' => 'Unknown Round B/C Affiliate',
            'category' => 'Round B/C Affiliates',
            'address' => '0x3885D15573E45228Dd54Cd4FDe9BfAc64d702ED4',
        ],
        [
            'label' => 'Unknown Round B/C Affiliate',
            'category' => 'Round B/C Affiliates',
            'address' => '0x3F12af735238C6E2FA45eFB5b2F3FAE82Df4c922',
        ],
        [
            'label' => 'Unknown Round B/C Affiliate',
            'category' => 'Round B/C Affiliates',
            'address' => '0x5b3fb4e1d6040615F3e681bEc4C80b5d7C958071',
        ],
        [
            'label' => 'Unknown Round B/C Affiliate',
            'category' => 'Round B/C Affiliates',
            'address' => '0x6cf32Cc52E220C023C2d92B1D62310F46a6E2a13',
        ],
        [
            'label' => 'Unknown Round B/C Affiliate',
            'category' => 'Round B/C Affiliates',
            'address' => '0x949423dB1BFeE1ddEc99c9D24a12a6eA27cb3489',
        ],
        [
            'label' => 'Unknown Round B/C Affiliate',
            'category' => 'Round B/C Affiliates',
            'address' => '0xB080454F190E76eB8e719560fA8CAE50c71bceA9',
        ],
        [
            'label' => 'Unknown Round B/C Affiliate',
            'category' => 'Round B/C Affiliates',
            'address' => '0xb5B6D8885fbF28f843Cc7886DE242B811d695205',
        ],
        [
            'label' => 'Unknown Round B/C Affiliate',
            'category' => 'Round B/C Affiliates',
            'address' => '0xd33D4F83e85c92E0B53ffe4FC0E18b0E3632C097',
        ],
        [
            'label' => 'Unknown Round B/C Affiliate',
            'category' => 'Round B/C Affiliates',
            'address' => '0xEbbDDf28bF3224791B0510a2AB8813f182fe4e2b',
        ],
        [
            'label' => 'Unknown Round B/C Affiliate',
            'category' => 'Round B/C Affiliates',
            'address' => '0xf8E6ecb4B0f17576525749bDF85524652cbf002E',
        ],
        [
            'label' => 'Unknown Round B/C Affiliate',
            'category' => 'Round B/C Affiliates',
            'address' => '0x887f2B16847248bc757b69F3c695F24Ff344dAF2',
        ],

    ];*/

}
