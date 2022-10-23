<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>

        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-FM26DHHWET"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());

          gtag('config', 'G-FM26DHHWET');
        </script>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ $title ?? 'Community Dashboard - Energy Web (unofficial)' }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;700&display=swap" rel="stylesheet">

        <!-- Fontawesome -->
        <link href="/fontawesome/css/all.css" rel="stylesheet">

        <!-- Stylesheets -->
        <link href="{{ URL::asset('/css/normalize.css') }}"  rel="stylesheet">
        <link href="{{ URL::asset('/css/main.css') }}"  rel="stylesheet">

    </head>
    <body class="antialiased">

        <div class="header-bar">
            <div class="container grid grid-header">
                <div class="logo">
                    <img src="https://www.energyweb.org/wp-content/uploads/2021/10/energyweb-logo-black.svg" />
                </div>
                <div class="title">
                    <h1><a href="/">EWChain.io</a> | Energy Web's unofficial community dashboard</h1>
                </div>
                <div class="navigation">
                    <ul>
                        <li><a href="/">Dashboard</a></li>
                        <li><a href="/wallets">Wallets</a></li>
                        <li><a href="/validators">Validators</a></li>
                    </ul>
                </div>
            </div>
        </div>

        {{ $slot }}

        <div class="footer-bar">
            <div class="container grid grid-footer">
                <div class="logo">
                    <img src="https://www.energyweb.org/wp-content/uploads/2021/10/energyweb-logo-black.svg" />
                </div>
                <div class="credits">
                    <a href="/">EWChain.io</a><br />
                    Build with <i class="fa fa-normal fa-heart" style="color:#a566ff;"></i> for $EWT <i class="fa fa-duotone fa-rocket-launch" style="color:#a566ff;"></i><br />
                    For updates please follow: <a href="https://twitter.com/joen862" target="_blank">@joen862</a> or <a href="https://github.com/joen862/ewtcd" target="_blank">check out GitHub</a>
                </div>
            </div>
        </div>

    </body>
</html>
