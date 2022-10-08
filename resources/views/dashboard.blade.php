<x-layout>

    <div class="container grid grid-dashboard">
        <div class="metrics-container">
            <div class="block">
                <h2>Supply (EWT)</h2>
                <table>
                    <tr>
                        <td>Max <i class="fa fa-light fa-circle-info" title="The maximum amount of EWT that will be brought into existence. It is generated by block rewards that are added to the Validator wallets and EWF Community Fund wallet."></i></td>
                        <td>{{number_format(100000000)}}</td>
                    </tr>
                    <tr>
                        <td>Total <i class="fa fa-light fa-circle-info" title="The total supply of EWT is fetched from https://explorer.energyweb.org/api?module=stats&action=coinsupply"></td>
                        <td>{{number_format($data['total'])}}</td>
                    </tr>
                    <tr>
                        <td>Circulating <i class="fa fa-light fa-circle-info" title="The total circulating supply of EWT is fetched from https://supply.energyweb.org and is confirmed by EW to be correct. It seems to be the tot supply minus the Team, Community Fund and Holding (unclaimed Founder 1) wallets."></td>
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
                        <td>{{number_format($wallets['founder1']['balance']+$wallets['holding']['balance'])}}</td>
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

                </table>
            </div>
            <div class="block">
                <h2>Market (USD)</h2>
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
            <div class="block">
                <h2>Bridged Token (EWTB)</h2>
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
            <div class="block">
                <h2>Exchanges (EWT)</h2>
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
                        <td>Bitmart:</td>
                        <td>{{number_format($wallets['bitmart']['balance'])}}</td>
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
            <div class="block">
                <h2>Staking Pools (EWT)</h2>
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
            <div class="block">
                <h2>Validators</h2>
                <table>
                    <tr>
                        <td>Active nodes/miners:</td>
                        <td>{{number_format($data['active-validators-count'])}}</td>
                    </tr>
                    <tr>
                        <td>Inactive nodes/miners:</td>
                        <td>{{number_format($data['inactive-validators-count'])}}</td>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="2">EWT Hold by:</td>
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
                <p>See: <a href="https://validator-dashboard.sandbox.energyweb.org/index.html" target="_blank">Official Energy Web Validator Dashboard</a> <i class="fa fa-external-link"></i></p>
            </div>
        </div>

        <div class="distribution-container">
            <div class="block">
                <h2>Token distribution</h2>
                <table>
                    <tr>
                        <th>Category</th>
                        <th>Description</th>
                        <th>Token Allocation <i class="fa fa-normal fa-circle-info" title="This is the amount of EWT that was given by the holding contract. See: https://explorer.energyweb.org/address/0x1204700000000000000000000000000000000004/contracts#address-tabs"></i></th>
                        <th>Current Balance  <i class="fa fa-normal fa-circle-info" title="The current balance of the wallet that received the Token Allocation OR the sum of wallets it is distributed to. E.g. in case of Founder2"></i></th>
                        <th>Moved <i class="fa fa-normal fa-circle-info" title="Moved is the difference between the Token Allocation and the Current Balance. These tokens have moved to subsequent addresses. It does not neccesarily mean the tokens have been moved to an exchange or sold. In case of Founder2 the tokens were distributed over 10 wallets that are tracked. We try to analyse more wallets."></i></th>
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
        </div>
    </div>
</x-layout>
