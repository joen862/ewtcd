<x-layout>

    <div class="container grid grid-dashboard">
        <div class="metrics-container">
            <div class="block">
                <h2>Supply (EWT)</h2>
                <table>
                    <tr>
                        <td class="row-title">Max Supply <i class="fa fa-light fa-circle-info" title="The maximum amount of EWT that will be brought into existence. It is generated by block rewards that are added to the Validator wallets and EWF Community Fund wallet."></i></td>
                        <td class="monospace">{{number_format(100000000)}}</td>
                    </tr>
                    <tr>
                        <td class="row-title">Total Supply <i class="fa fa-light fa-circle-info" title="The total supply of EWT is fetched from https://explorer.energyweb.org/api?module=stats&action=coinsupply"></td>
                        <td class="monospace">{{number_format($data['total'])}}</td>
                    </tr>

                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>

                    <tr>
                        <td colspan="2" class="row-title">Not in circulation  <i class="fa fa-light fa-circle-info" title="This is considered not in circulation. Given that supply.energyweb.org gives a circulating supply which is the same as the total minus these wallets."></td>
                    </tr>
                    <tr>
                        <td class="row-subtitle">Team (Endowment & Ops):</td>
                        <td class="monospace">{{number_format($wallets['team']['balance'])}}</td>
                    </tr>
                    <tr>
                        <td class="row-subtitle">Community Fund:</td>
                        <td class="monospace">{{number_format($wallets['community']['balance'])}}</td>
                    </tr>
                    <tr>
                        <td class="row-subtitle">Distribution Contract (Grid Singularity):</td>
                        <td class="monospace">{{number_format($wallets['holding']['balance'])}}</td>
                    </tr>

                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>

                    <tr>
                        <td colspan="2" class="row-title">In Circulation  <i class="fa fa-light fa-circle-info" title="All other wallets that are considered in circulation. Lockup periods have ended, so these funds can move into general circulation at any moment."></td>
                    </tr>
                    <tr>
                        <td class="row-subtitle">RMI:</td>
                        <td class="monospace">{{number_format($data['founder2-total'])}}</td>
                    </tr>
                    <tr>
                        <td class="row-subtitle">Round A Affiliates:</td>
                        <td class="monospace">{{number_format($data['rounda-total'])}}</td>
                    </tr>
                    <tr>
                        <td class="row-subtitle">Round B/C Affiliates:</td>
                        <td class="monospace">{{number_format($data['roundbc-total'])}}</td>
                    </tr>
                    <tr>
                        <td class="row-subtitle">All other:</td>
                        <td class="monospace">{{number_format($data['circulating-supply']-$data['founder2-total']-$data['rounda-total']-$data['roundbc-total'])}}</td>
                    </tr>

                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>

                    <tr>
                        <td class="row-title">Circulating Supply <i class="fa fa-light fa-circle-info" title="The total circulating supply of EWT is fetched from https://supply.energyweb.org and is confirmed by EW to be correct. It seems to be the tot supply minus the Team, Community Fund and Holding (unclaimed Grid Singularity) wallets."></td>
                        <td class="monospace">{{number_format($data['circulating-supply'])}}</td>
                    </tr>
                    <tr>
                        <td colspan="2">Circulating = Total - Team - Community - Distribution</td>
                    </tr>




                </table>
            </div>
            <div class="block">
                <h2>Market (USD)</h2>
                <table>
                    <tr>
                        <td class="row-title">Price:</td>
                        <td class="monospace">&dollar; {{number_format($market->price,2)}}</td>
                    </tr>
                    <tr>
                        <td class="row-title">24H price change:</td>
                        <td class="monospace">{{number_format($market->percent_change_24h,2)}}%</td>
                    </tr>
                    <tr>
                        <td class="row-title">24H Volume:</td>
                        <td class="monospace">&dollar; {{number_format($market->volume_24h,2)}}</td>
                    </tr>
                    <tr>
                        <td class="row-title">24H Volume change:</td>
                        <td class="monospace">{{number_format($market->volume_change_24h,2)}}%</td>
                    </tr>
                    <tr>
                        <td class="row-title">Market Cap  <i class="fa fa-light fa-circle-info" title="This is a calculated marketcap of circulating supply times price. The marketcap given by CoinMarketCap is incorrect. "></td>
                        <td class="monospace">&dollar; {{number_format($data['circulating-supply']*$market->price)}}</td>
                    </tr>
                    <tr>
                        <td class="row-title">Fully Diluted Market Cap:</td>
                        <td class="monospace">&dollar; {{number_format($market->fully_diluted_market_cap)}}</td>
                    </tr>
                </table>
            </div>
            <div class="block">
                <h2>Bridged Token (EWTB)</h2>
                <table>
                    <tr>
                        <td class="row-title">Minted:</td>
                        <td class="monospace">{{number_format($data['ewtb-total'])}}</td>
                    </tr>
                    <tr>
                        <td class="row-title">TXs Last Day:</td>
                        <td class="monospace">{{number_format($data['ewtb-last-day'])}}</td>
                    </tr>
                    <tr>
                        <td class="row-title">TXs Last Week:</td>
                        <td class="monospace">{{number_format($data['ewtb-last-week'])}}</td>
                    </tr>
                    <tr>
                        <td class="row-title">TXs Last Month:</td>
                        <td class="monospace">{{number_format($data['ewtb-last-month'])}}</td>
                    </tr>
                </table>
            </div>
            <div class="block">
                <h2>Exchanges (EWT)</h2>
                <table>
                    <tr>
                        <td class="row-title">Kucoin:</td>
                        <td class="monospace">{{number_format($wallets['kucoin-cold']['balance']+$wallets['kucoin-hot']['balance']+$wallets['kucoin-hot2']['balance'])}}</td>
                    </tr>
                    <tr>
                        <td class="row-title">Kraken:</td>
                        <td class="monospace">{{number_format($wallets['kraken']['balance'])}}</td>
                    </tr>
                    <tr>
                        <td class="row-title">Bitmart:</td>
                        <td class="monospace">{{number_format($wallets['bitmart']['balance'])}}</td>
                    </tr>
                    <tr>
                        <td class="row-title">Gate.io:</td>
                        <td class="monospace">{{number_format($wallets['gate']['balance'])}}</td>
                    </tr>
                    <tr>
                        <td class="row-title">Hotbit:</td>
                        <td class="monospace">{{number_format($wallets['hotbit']['balance'])}}</td>
                    </tr>
                    <tr>
                        <td class="row-title">Liquid:</td>
                        <td class="monospace">{{number_format($wallets['liquid']['balance'])}}</td>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="row-title">Total Exchanges:</td>
                        <td class="monospace">{{number_format($data['total-exchanges'])}}</td>
                    </tr>
                    <tr>
                        <td class="row-title">Exchanges %:</td>
                        <td class="monospace">{{number_format($data['total-exchanges']/$data['circulating-supply']*100,2)}}%</td>
                    </tr>
                </table>
            </div>
            <div class="block">
                <h2>Staking Pools (EWT)</h2>
                <table>
                    <tr>
                        <td class="row-title">Booster Pool:</td>
                        <td class="monospace">{{number_format($wallets['booster']['balance'])}}</td>
                    </tr>
                    <tr>
                        <td class="row-title">EEA Pool:</td>
                        <td class="monospace">{{number_format($wallets['eea']['balance'])}}</td>
                    </tr>
                    <tr>
                        <td class="row-title">CRC Pool:</td>
                        <td class="monospace">{{number_format($wallets['crc']['balance'])}}</td>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="row-title">Total Staked:</td>
                        <td class="monospace">{{number_format($data['total-staked'])}}</td>
                    </tr>
                    <tr>
                        <td class="row-title">Staked EWT %:</td>
                        <td class="monospace">{{number_format($data['total-staked']/$data['circulating-supply']*100,2)}}%</td>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                </table>
            </div>
            <div class="block">
                <h2>Validators</h2>
                <table>
                    <tr>
                        <td>&nbsp;</td>
                        <td class="column-title right">Validators</td>
                        <td class="column-title right">Mining wallets</td>
                        <td class="column-title right">Holding EWT</td>
                    </tr>
                    <tr>
                        <td class="row-title">Active</td>
                        <td class="monospace">{{number_format($data['active-validators-count'])}}</td>
                        <td class="monospace">{{number_format($data['active-miners-count'])}}</td>
                        <td class="monospace">{{number_format($data['active-miners-holding'])}}</td>
                    </tr>
                    <tr>
                        <td class="row-title">Inactive</td>
                        <td class="monospace">{{number_format($data['inactive-validators-count'])}}</td>
                        <td class="monospace">{{number_format($data['inactive-miners-count'])}}</td>
                        <td class="monospace">{{number_format($data['inactive-miners-holding'])}}</td>
                    </tr>
                    <tr>
                        <td class="row-title">Unknown</td>
                        <td class="monospace"></td>
                        <td class="monospace">{{number_format($data['unknown-miners-count'])}}</td>
                        <td class="monospace">{{number_format($data['unknown-miners-holding'])}}</td>
                    </tr>
                </table>
                <p>See: <a href="https://validator-dashboard.sandbox.energyweb.org/index.html" target="_blank">Official Energy Web Validator Dashboard</a> <i class="fa fa-external-link"></i></p>
            </div>
        </div>

        <div class="distribution-container">
            <div class="block">
                <h2>Token distribution</h2>
                <table class="show-table">
                    <tr>
                        <th>Category</th>
                        <th>Description</th>
                        <th>Token Allocation <i class="fa fa-normal fa-circle-info" title="This is the amount of EWT that was given by the holding contract. See: https://explorer.energyweb.org/address/0x1204700000000000000000000000000000000004/contracts#address-tabs"></i></th>
                        <th>Current Balance  <i class="fa fa-normal fa-circle-info" title="The current balance of the wallet that received the Token Allocation OR the sum of wallets it is distributed to. E.g. in case of RMI"></i></th>
                        <th>Moved <i class="fa fa-normal fa-circle-info" title="Moved is the difference between the Token Allocation and the Current Balance. These tokens have moved to subsequent addresses. It does not neccesarily mean the tokens have been moved to an exchange or sold. In case of RMI the tokens were distributed over 10 wallets that are tracked. We try to analyse more wallets."></i></th>
                    </tr>
                    <tr>
                        <td>EWF Operating Fund</td>
                        <td>Tokens for EWF operations</td>
                        <td class="monospace">10,901,792</td>
                        <td rowspan="2" class="monospace">{{number_format($wallets['team']['balance'])}}</td>
                        <td rowspan="2" class="monospace">{{number_format(20901792-$wallets['team']['balance'])}}</td>
                    </tr>
                    <tr>
                        <td>EWF Endowment</td>
                        <td>Tokens intended for additional technology development in support of EWF mission</td>
                        <td class="monospace">10,000,000</td>
                    </tr>
                    <tr>
                        <td>EWF Community Fund</td>
                        <td>Community fund tokens will be used to support development of new technologies in the EWF ecosystem</td>
                        <td class="monospace">37,900,000</td>
                        <td class="monospace">{{number_format($wallets['community']['balance'])}}</td>
                        <td>n/a</td>
                    </tr>
                    <tr>
                        <td>Validator Block Reward</td>
                        <td>Allocated to block validation rewards, and released continuously (on a per-block basis) over a period of 10 years in a logarithmic curve</td>
                        <td class="monospace">10,000,000</td>
                        <td class="monospace">{{number_format($data['active-miners-holding']+$data['inactive-miners-holding'])}}</td>
                        <td>n/a</td>
                    </tr>
                    <tr>
                        <td rowspan="2">Founder Tokens</td>
                        <td rowspan="2">Allocated to EWF co-founders Rocky Mountain Institute and Grid Singularity</td>
                        <td rowspan="2" class="monospace">10,000,000</td>
                        <td class="monospace">5,000,000</td>
                        <td class="monospace">0</td>
                    </tr>
                    <tr>
                        <td class="monospace">{{number_format($data['founder2-total'])}}</td>
                        <td class="monospace">{{number_format(5000000-$data['founder2-total'])}}</td>
                    </tr>
                    <tr>
                        <td>Round A Affiliates</td>
                        <td>Allocated to the 10 initial Affiliates of EWF</td>
                        <td class="monospace">5,000,000</td>
                        <td class="monospace">{{number_format($data['rounda-total'])}}</td>
                        <td class="monospace">{{number_format(5000000-$data['rounda-total'])}}</td>
                    </tr>
                    <tr>
                        <td>Round B Affiliates</td>
                        <td>Allocated to Affiliates who joined EWF in a B round of fundraising</td>
                        <td class="monospace">15,863,208</td>
                        <td rowspan="2" class="monospace">{{number_format($data['roundbc-total'])}}</td>
                        <td rowspan="2" class="monospace">{{number_format(16198208-$data['roundbc-total'])}}</td>
                    </tr>
                    <tr>
                        <td>Round C Affiliates</td>
                        <td>Allocated to Affiliates who joined EWF</td>
                        <td class="monospace">335,000</td>
                    </tr>
                    <tr>
                        <th colspan="2" style="text-align:right;">Total</th>
                        <th class="monospace">100,000,000</th>
                        <th colspan="2"></th>
                    </tr>

                </table>

            </div>
        </div>
    </div>
</x-layout>
