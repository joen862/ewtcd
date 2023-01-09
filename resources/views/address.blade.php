<x-layout>

<div class="top-banner">
    <div class="container grid address-details">
        <div id="address-title">
            <h1 class="top-header">@if($wallet){{$wallet['label']}} <span class="address_category">{{$wallet['category']}}</span>@else Address @endif<br>
            <span class="normal monospace">{{$address}}</span></h1>
            @if($wallet && $wallet['notes'])
                <p><b>Notes:</b><br>
                {{$wallet['notes']}}</p>
            @endif
        </div>
        <div id="address-balance">
            <h2 class="top-header">Balance<br>
            <span class="normal monospace">{{number_format($balance)}}</span> EWT</h2>
        </div>
    </div>
</div>

<div class="container">

    <p><b>Please keep in mind:</b></p>
    <ul>
        <li>Transactions with 0 EWT value are not indexed (e.g. staking pool registration).</li>
        <li>Currently only normal transactions are indexed. Internal transactions (as you can find on explorerer.energyweb.org) are not yet indexed.</li>
        <li>For testing and performance reasons, the amount of unique wallets fetched is limited to the top 25 (by amount of EWT). Sorting or searching the table will only affect the current table, it will not fetch new data from the database.</li>
        <li>This page is in active development and fetches data from a live node, unlike before. Things may change and things might fail (e.g. slow loading or unforeseen errors). If you experience any issues or if you have feedback please DM <a href="https://twitter.com/joen862" target="_blank">@joen862</a>.</li>
    </ul>

    @if($from)

        <div class="block address_from">
            <h2>EWT received from:</h2>

            <table id="addr_received_from" class="show-table display">
                <thead>
                    <tr>
                        <th style="width:5rem;"">Total Tx</th>
                        <th style="width:5rem;"">Total EWT</th>
                        <th style="width:30rem;">From</th>
                        <th>Tracked wallet</th>
                        <th style="width:15rem;">First Tx</th>
                        <th style="width:15rem;">Latest Tx</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($from as $received)
                        <tr>
                            <td class="monospace">{{number_format($received['count_tx'])}}</td>
                            <td class="monospace">{{number_format($received['total_ewt'])}}</td>
                            <td class="monospace left"><a href="/address/{{$received['from']}}">{{$received['from']}}</a></td>
                            <td>
                                @if(isset($received['wallet']))
                                    <b>{{$received['wallet']['label']}}</b> <span class="address_category">{{$received['wallet']['category']}}</span>
                                @endif
                            </td>
                            <td class="monospace left">{{$received['first_date']}}</td>
                            <td class="monospace left">{{$received['latest_date']}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <script>
            $(document).ready( function () {
                $('#addr_received_from').DataTable({
                    paging:false,
                    order:[[1,'desc']],
                });
            } );
        </script>

    @endif



    @if($to)
        <div class="block address_to">
            <h2>EWT sent to:</h2>

            <table id="addr_sent_to" class="show-table display">
                <thead>
                    <tr>
                        <th style="width:5rem;"">Total Tx</th>
                        <th style="width:5rem;"">Total EWT</th>
                        <th style="width:30rem;">To</th>
                        <th>Tracked wallet</th>
                        <th style="width:15rem;">First Tx</th>
                        <th style="width:15rem;">Latest Tx</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($to as $sent)
                        <tr>
                            <td class="monospace">{{number_format($sent['count_tx'])}}</td>
                            <td class="monospace">{{number_format($sent['total_ewt'])}}</td>
                            <td class="monospace left"><a href="/address/{{$sent['to']}}">{{$sent['to']}}</a></td>
                            <td>
                                @if(isset($sent['wallet']))
                                    <b>{{$sent['wallet']['label']}}</b> <span class="address_category">{{$sent['wallet']['category']}}</span>
                                @endif
                            </td>
                            <td class="monospace left">{{$sent['first_date']}}</td>
                            <td class="monospace left">{{$sent['latest_date']}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <script>
            $(document).ready( function () {
                $('#addr_sent_to').DataTable({
                    paging:false,
                    order:[[1,'desc']],
                });
            } );
        </script>

    @endif

</div>

</x-layout>
