<x-layout>
    <div class="wallets-container">
        <div class="block">
            <h2>Tracked wallets</h2>
            <table>
                <tr>
                    <th>Category</th>
                    <th>Label</th>
                    <th>Address</th>
                    <th>Start Balance <i class="fa fa-normal fa-circle-info" title="This is the amount that the wallet initially received from the holding contract (token allocation) or from such wallet (in case of Founder2)"></th>
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
