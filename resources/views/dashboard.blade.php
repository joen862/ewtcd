<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Community Dashboard - Energy Web (unofficial)</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;700&display=swap" rel="stylesheet">


        <!-- Styles -->
        <style>
            /*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */html{line-height:1.15;-webkit-text-size-adjust:100%}body{margin:0}a{background-color:transparent}[hidden]{display:none}html{font-family:system-ui,-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,Noto Sans,sans-serif,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol,Noto Color Emoji;line-height:1.5}*,:after,:before{box-sizing:border-box;border:0 solid #e2e8f0}a{color:inherit;text-decoration:inherit}svg,video{display:block;vertical-align:middle}video{max-width:100%;height:auto}.bg-white{--bg-opacity:1;background-color:#fff;background-color:rgba(255,255,255,var(--bg-opacity))}.bg-gray-100{--bg-opacity:1;background-color:#f7fafc;background-color:rgba(247,250,252,var(--bg-opacity))}.border-gray-200{--border-opacity:1;border-color:#edf2f7;border-color:rgba(237,242,247,var(--border-opacity))}.border-t{border-top-width:1px}.flex{display:flex}.grid{display:grid}.hidden{display:none}.items-center{align-items:center}.justify-center{justify-content:center}.font-semibold{font-weight:600}.h-5{height:1.25rem}.h-8{height:2rem}.h-16{height:4rem}.text-sm{font-size:.875rem}.text-lg{font-size:1.125rem}.leading-7{line-height:1.75rem}.mx-auto{margin-left:auto;margin-right:auto}.ml-1{margin-left:.25rem}.mt-2{margin-top:.5rem}.mr-2{margin-right:.5rem}.ml-2{margin-left:.5rem}.mt-4{margin-top:1rem}.ml-4{margin-left:1rem}.mt-8{margin-top:2rem}.ml-12{margin-left:3rem}.-mt-px{margin-top:-1px}.max-w-6xl{max-width:72rem}.min-h-screen{min-height:100vh}.overflow-hidden{overflow:hidden}.p-6{padding:1.5rem}.py-4{padding-top:1rem;padding-bottom:1rem}.px-6{padding-left:1.5rem;padding-right:1.5rem}.pt-8{padding-top:2rem}.fixed{position:fixed}.relative{position:relative}.top-0{top:0}.right-0{right:0}.shadow{box-shadow:0 1px 3px 0 rgba(0,0,0,.1),0 1px 2px 0 rgba(0,0,0,.06)}.text-center{text-align:center}.text-gray-200{--text-opacity:1;color:#edf2f7;color:rgba(237,242,247,var(--text-opacity))}.text-gray-300{--text-opacity:1;color:#e2e8f0;color:rgba(226,232,240,var(--text-opacity))}.text-gray-400{--text-opacity:1;color:#cbd5e0;color:rgba(203,213,224,var(--text-opacity))}.text-gray-500{--text-opacity:1;color:#a0aec0;color:rgba(160,174,192,var(--text-opacity))}.text-gray-600{--text-opacity:1;color:#718096;color:rgba(113,128,150,var(--text-opacity))}.text-gray-700{--text-opacity:1;color:#4a5568;color:rgba(74,85,104,var(--text-opacity))}.text-gray-900{--text-opacity:1;color:#1a202c;color:rgba(26,32,44,var(--text-opacity))}.underline{text-decoration:underline}.antialiased{-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.w-5{width:1.25rem}.w-8{width:2rem}.w-auto{width:auto}.grid-cols-1{grid-template-columns:repeat(1,minmax(0,1fr))}@media (min-width:640px){.sm\:rounded-lg{border-radius:.5rem}.sm\:block{display:block}.sm\:items-center{align-items:center}.sm\:justify-start{justify-content:flex-start}.sm\:justify-between{justify-content:space-between}.sm\:h-20{height:5rem}.sm\:ml-0{margin-left:0}.sm\:px-6{padding-left:1.5rem;padding-right:1.5rem}.sm\:pt-0{padding-top:0}.sm\:text-left{text-align:left}.sm\:text-right{text-align:right}}@media (min-width:768px){.md\:border-t-0{border-top-width:0}.md\:border-l{border-left-width:1px}.md\:grid-cols-2{grid-template-columns:repeat(2,minmax(0,1fr))}}@media (min-width:1024px){.lg\:px-8{padding-left:2rem;padding-right:2rem}}@media (prefers-color-scheme:dark){.dark\:bg-gray-800{--bg-opacity:1;background-color:#2d3748;background-color:rgba(45,55,72,var(--bg-opacity))}.dark\:bg-gray-900{--bg-opacity:1;background-color:#1a202c;background-color:rgba(26,32,44,var(--bg-opacity))}.dark\:border-gray-700{--border-opacity:1;border-color:#4a5568;border-color:rgba(74,85,104,var(--border-opacity))}.dark\:text-white{--text-opacity:1;color:#fff;color:rgba(255,255,255,var(--text-opacity))}.dark\:text-gray-400{--text-opacity:1;color:#cbd5e0;color:rgba(203,213,224,var(--text-opacity))}.dark\:text-gray-500{--tw-text-opacity:1;color:#6b7280;color:rgba(107,114,128,var(--tw-text-opacity))}}
        </style>

        <style>
            body {
                font-family: 'Rajdhani', sans-serif;
                background-color: #f6f7f8;
            }
            .container {
                display: flex;
                justify-content: left;
            }

            h2 {
                margin:0 0 20px 0;
                padding:0;
                color:#a566ff;
            }

            td:first-child {
                font-weight: bold;
                padding-right: 20px;
            }
            td:nth-child(2) {
                text-align: right;
            }

            .block {
                background-color: #FFF;
                padding:20px;
                margin: 0 20px 20px 20px;
            }

            .logo img {
                height: 60px;
            }

            .logo {
                margin:20px;
            }

            div:has(.logo) h1 {
                font-size: 20px;
                line-height: 60px;
                font-weight: normal;
                margin:20px;
                padding:0;
            }

            a.update {
                line-height: 60px;
                margin:20px;
                font-size: 10px;
                color:#999;
                text-decoration: underline;
            }


        </style>
    </head>
    <body class="antialiased">
        <div class="container">
            <img class="logo" src="https://www.energyweb.org/wp-content/uploads/2021/10/energyweb-logo-black.svg" height="60px" />
            <h1>Community Dashboard</h1>
        </div>
        <div class="container">

            <div class="block">
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
            <div class="block">
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
            <div class="block">
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
            <div class="block">
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
            <div class="block">
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
                        <td>{{number_format($data['crc-staked'])}}</td>
                    </tr>
                    <tr>
                        <td>CRC Rewarded/max:</td>
                        <td>{{number_format($data['crc-rewards'])}} / {{number_format($data['crc-max-rewards'])}}</td>
                    </tr>
                    <tr>
                        <td>CRC Pool Filled:</td>
                        <td>{{number_format($data['crc-staked']/7500000*100,2)}}%</td>
                    </tr>
                </table>
            </div>
        </div>
        <?php //dump($wallets); ?>
    </body>
</html>
