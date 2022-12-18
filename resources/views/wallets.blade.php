
<x-layout>
    <div class="container">
        <div class="wallets-container">
            <div class="block">
                <h2>Tracked wallets</h2>
                <table id="tracked_wallets" class="show-table display">
                    <thead>
                        <tr>
                            <!--<th style="width:10rem;">Category</th>-->
                            <th style="width:20rem;">Category</th>
                            <th style="width:20rem;">Label</th>
                            <th style="width:10rem;">Address</th>
                            <th style="width:10rem;">Start Balance <i class="fa fa-normal fa-circle-info" title="This is the amount that the wallet initially received from the holding contract (token allocation) or from such wallet (in case of Founder2)"></th>
                            <th style="width:10rem;">Current Balance</th>
                            <th>Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($wallets as $wallet)
                        <tr>
                            <!--<td>{{$wallet['category']}}</td>-->
                            <td>{{$wallet['category']}}</td>
                            <td>{{$wallet['label']}}</td>
                            <td class="text-left "><a href="https://explorer.energyweb.org/address/{{$wallet['address']}}/coin-balances#address-tabs" target="_blank">{{substr($wallet['address'],0,8)}}-{{substr($wallet['address'],36,6)}}</a><span style="display:none;">{{$wallet['address']}}</span></td>
                            <td class="monospace text-right">{{number_format($wallet['token_allocation'])}}</td>
                            <td class="monospace text-right">{{number_format($wallet['balance'])}}</td>
                            <td>{{$wallet['notes']}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        $(document).ready( function () {
            $('#tracked_wallets').DataTable({
                paging:false,
                order:[[3,'desc']],
            });
        } );
    </script>
</x-layout>
