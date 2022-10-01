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
        <div class="container">

        <div class="header">
            <div class="logo"><img src="https://www.energyweb.org/wp-content/uploads/2021/10/energyweb-logo-black.svg" height="60px" /></div>
            <div class="nav"><a href="/">Dashboard</a> | <a href="/wallets">Wallets</a></div>
            <div class="payoff"><h1><a href="/">EWChain.io</a><br />Energy Web (unofficial) Community Dashboard (beta)</h1></div>
        </div>

        {{ $slot }}

        <div class="footer">
                <div class="logo"><img src="https://www.energyweb.org/wp-content/uploads/2021/10/energyweb-logo-black.svg" height="60px" /></div>
                <div class="payoff">
                    <a href="/">EWChain.io</a><br />
                    Energy Web (unofficial) Community Dashboard (beta)<br />
                    Build with <i class="fa fa-normal fa-heart" style="color:#a566ff;"></i> for $EWT <i class="fa fa-duotone fa-rocket-launch" style="color:#a566ff;"></i><br />
                    For updates please follow: <a href="https://twitter.com/joen862">@joen862</a></div>
            </div>

        </div>
    </body>
</html>
