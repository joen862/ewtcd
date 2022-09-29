<x-layout>
        <div class="container">
            <img class="logo" src="https://www.energyweb.org/wp-content/uploads/2021/10/energyweb-logo-black.svg" height="60px" />
            <h1>Community Dashboard</h1>
        </div>
        <div class="container">
            <div class="block metrics">
                <h2>Supply</h2>
                <table>
                    <tr>
                        <td>Max:</td>
                        <td>{{number_format(100000000)}}</td>
                    </tr>
                    <tr>
                        <td>Total:</td>
                        <td>{{number_format($data['total'])}}</td>
                    </tr>
                    <tr>
                        <td>Circulating:</td>
                        <td>{{number_format($data['circulating-supply'])}}</td>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Team (Endowment & Ops):</td>
                        <td>{{number_format($wallets['team']['balance'])}}</td>
                    </tr>
                    <tr>
                        <td>Community Fund:</td>
                        <td>{{number_format($wallets['community']['balance'])}}</td>
                    </tr>
                    <tr>
                        <td>Founder1:</td>
                        <td>{{number_format($wallets['founder1']['balance'])}}</td>
                    </tr>
                    <tr>
                        <td>Founder2:</td>
                        <td>{{number_format($data['founder2-total'])}}</td>
                    </tr>
                    <tr>
                        <td>Round A Affiliates:</td>
                        <td>{{number_format($data['rounda-total'])}}</td>
                    </tr>
                    <tr>
                        <td>Round B/C Affiliates:</td>
                        <td>{{number_format($data['roundbc-total'])}}</td>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Active Validators:</td>
                        <td>{{number_format($data['active-validators'])}}</td>
                    </tr>
                    <tr>
                        <td>Inactive Validators:</td>
                        <td>{{number_format($data['inactive-validators'])}}</td>
                    </tr>

                </table>
            </div>
            <div class="block metrics">
                <h2>Market ($USD)</h2>
                <table>
                    <tr>
                        <td>Price:</td>
                        <td>&dollar; {{number_format($market->price,2)}}</td>
                    </tr>
                    <tr>
                        <td>24H price change:</td>
                        <td>{{number_format($market->percent_change_24h,2)}}%</td>
                    </tr>
                    <tr>
                        <td>24H Volume:</td>
                        <td>&dollar; {{number_format($market->volume_24h,2)}}</td>
                    </tr>
                    <tr>
                        <td>24H Volume change:</td>
                        <td>{{number_format($market->volume_change_24h,2)}}%</td>
                    </tr>
                    <tr>
                        <td>Market Cap:</td>
                        <td>&dollar; {{number_format($market->market_cap)}}</td>
                    </tr>
                    <tr>
                        <td>Corrected Market Cap:</td>
                        <td>&dollar; {{number_format($data['circulating-supply']*$market->price)}}</td>
                    </tr>
                    <tr>
                        <td>Fully Diluted Market Cap:</td>
                        <td>&dollar; {{number_format($market->fully_diluted_market_cap)}}</td>
                    </tr>
                </table>
            </div>
            <div class="block metrics">
                <h2>Bridged Token</h2>
                <table>
                    <tr>
                        <td>Minted:</td>
                        <td>{{number_format($data['ewtb-total'])}}</td>
                    </tr>
                    <tr>
                        <td>TXs Last Day:</td>
                        <td>{{number_format($data['ewtb-last-day'])}}</td>
                    </tr>
                    <tr>
                        <td>TXs Last Week:</td>
                        <td>{{number_format($data['ewtb-last-week'])}}</td>
                    </tr>
                    <tr>
                        <td>TXs Last Month:</td>
                        <td>{{number_format($data['ewtb-last-month'])}}</td>
                    </tr>
                </table>
            </div>
            <div class="block metrics">
                <h2>Exchanges</h2>
                <table>
                    <tr>
                        <td>Kraken:</td>
                        <td>{{number_format($wallets['kraken']['balance'])}}</td>
                    </tr>
                    <tr>
                        <td>Kucoin (cold):</td>
                        <td>{{number_format($wallets['kucoin-cold']['balance'])}}</td>
                    </tr>
                    <tr>
                        <td>Kucoin (hot):</td>
                        <td>{{number_format($wallets['kucoin-hot']['balance'])}}</td>
                    </tr>
                    <tr>
                        <td>Hotbit:</td>
                        <td>{{number_format($wallets['hotbit']['balance'])}}</td>
                    </tr>
                    <tr>
                        <td>Gate.io:</td>
                        <td>{{number_format($wallets['gate']['balance'])}}</td>
                    </tr>
                    <tr>
                        <td>Liquid:</td>
                        <td>{{number_format($wallets['liquid']['balance'])}}</td>
                    </tr>
                    <tr>
                        <td>Bitmart:</td>
                        <td>??</td>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Total Exchanges:</td>
                        <td>{{number_format($data['total-exchanges'])}}</td>
                    </tr>
                    <tr>
                        <td>Exchanges %:</td>
                        <td>{{number_format($data['total-exchanges']/$data['circulating-supply']*100,2)}}%</td>
                    </tr>
                </table>
            </div>
            <div class="block metrics">
                <h2>Staking Pools</h2>
                <table>
                    <tr>
                        <td>Booster Pool:</td>
                        <td>{{number_format($wallets['booster']['balance'])}}</td>
                    </tr>
                    <tr>
                        <td>EEA Pool:</td>
                        <td>{{number_format($wallets['eea']['balance'])}}</td>
                    </tr>
                    <tr>
                        <td>CRC Pool:</td>
                        <td>{{number_format($wallets['crc']['balance'])}}</td>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Total Staked:</td>
                        <td>{{number_format($data['total-staked'])}}</td>
                    </tr>
                    <tr>
                        <td>Staked EWT %:</td>
                        <td>{{number_format($data['total-staked']/$data['circulating-supply']*100,2)}}%</td>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td>CRC Staked:</td>
                        <!--<td>{{number_format($data['crc-staked'])}}</td>-->
                        <td>Coming...</td>
                    </tr>
                    <tr>
                        <td>CRC Pool Filled:</td>
                        <!--<td>{{number_format($data['crc-staked']/7500000*100,2)}}%</td>-->
                        <td>Coming...</td>
                    </tr>
                </table>
            </div>
            <div class="block distribution">
                <h2>Token distribution</h2>
                <table>
                    <tr>
                        <th>Category</th>
                        <th>Description</th>
                        <th>Token Allocation</th>
                        <th>Current Balance</th>
                        <th>Moved</th>
                    </tr>
                    <tr>
                        <td>EWF Operating Fund</td>
                        <td>Tokens for EWF operations</td>
                        <td>10,901,792</td>
                        <td rowspan="2">{{number_format($wallets['team']['balance'])}}</td>
                        <td rowspan="2">{{number_format(20901792-$wallets['team']['balance'])}}</td>
                    </tr>
                    <tr>
                        <td>EWF Endowment</td>
                        <td>Tokens intended for additional technology development in support of EWF mission</td>
                        <td>10,000,000</td>
                    </tr>
                    <tr>
                        <td>EWF Community Fund</td>
                        <td>Community fund tokens will be used to support development of new technologies in the EWF ecosystem</td>
                        <td>37,900,000</td>
                        <td>{{number_format($wallets['community']['balance'])}}</td>
                        <td>n/a</td>
                    </tr>
                    <tr>
                        <td>Validator Block Reward</td>
                        <td>Allocated to block validation rewards, and released continuously (on a per-block basis) over a period of 10 years in a logarithmic curve</td>
                        <td>10,000,000</td>
                        <td>{{number_format($data['active-validators']+$data['inactive-validators'])}}</td>
                        <td>n/a</td>
                    </tr>
                    <tr>
                        <td rowspan="2">Founder Tokens</td>
                        <td rowspan="2">Allocated to EWF co-founders Rocky Mountain Institute and GridSingularity</td>
                        <td rowspan="2">10,000,000</td>
                        <td>5,000,000</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td class="monospace">{{number_format($data['founder2-total'])}}</td>
                        <td class="monospace">{{number_format(5000000-$data['founder2-total'])}}</td>
                    </tr>
                    <tr>
                        <td>Round A Affiliates</td>
                        <td>Allocated to the 10 initial Affiliates of EWF</td>
                        <td>5,000,000</td>
                        <td>{{number_format($data['rounda-total'])}}</td>
                        <td>{{number_format(5000000-$data['rounda-total'])}}</td>
                    </tr>
                    <tr>
                        <td>Round B Affiliates</td>
                        <td>Allocated to Affiliates who joined EWF in a B round of fundraising</td>
                        <td>15,863,208</td>
                        <td rowspan="2">{{number_format($data['roundbc-total'])}}</td>
                        <td rowspan="2">{{number_format(16198208-$data['roundbc-total'])}}</td>
                    </tr>
                    <tr>
                        <td>Round C Affiliates</td>
                        <td>Allocated to Affiliates who joined EWF</td>
                        <td>335,000</td>
                    </tr>
                    <tr>
                        <th colspan="2" style="text-align:right;">Total</th>
                        <th style="font-family:monospace; text-align:right;">100,000,000</th>
                        <th colspan="2"></th>
                    </tr>

                </table>

            </div>

            <div class="block">
                <h2>Tracked wallets</h2>
                <table>
                    <tr>
                        <th>Category</th>
                        <th>Label</th>
                        <th>Address</th>
                        <th>Start Balance</th>
                        <th>Current Balance</th>
                        <th>Notes</th>
                    </tr>
                    @foreach($wallets as $wallet)
                    <tr>
                        <td>{{$wallet['category']}}</td>
                        <td>{{$wallet['label']}}</td>
                        <td><a href="https://explorer.energyweb.org/address/{{$wallet['address']}}/coin-balances#address-tabs" target="_blank">{{substr($wallet['address'],0,8)}}-{{substr($wallet['address'],36,6)}}</a></td>
                        <td class="monospace text-right">{{number_format($wallet['token_allocation'])}}</td>
                        <td class="monospace text-right">{{number_format($wallet['balance'])}}</td>
                        <td>{{$wallet['notes']}}</td>
                    </tr>
                    @endforeach
                </table>
            </div>

        </div>

</x-layout>
