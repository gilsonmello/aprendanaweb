<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="_token" content="{{ csrf_token() }}" />
        <title>@yield('title', app_name())</title>
        <meta name="description" content="@yield('meta_description', 'O Brasil Jurídico – Ensino de Alta Performance é uma instituição de ensino que nasceu com o fiel propósito e o compromisso ético de oferecer aos seus alunos e à toda comunidade jurídica do país um conteúdo didático arrojado e de excelência, com métodos e recursos modernos, indispensáveis ao crescimento profissional.')">
        <meta name="author" content="@yield('author', 'Brasil Jurídico')">
        @yield('meta')

        @yield('before-styles-end')
        {!! HTML::style(elixir('css/frontend.css')) !!}
        @yield('after-styles-end')

        <!-- Fonts -->
        <link href='https://fonts.googleapis.com/css?family=Titillium+Web:400,700' rel='stylesheet' type='text/css'>

        <link href='https://fonts.googleapis.com/css?family=Signika+Negative:400,300,600,700' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Titillium+Web:400,400italic,600,900,700italic,700,600italic,300italic,200italic,200,300' rel='stylesheet' type='text/css'>



        <!-- Icons-->
        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <!-- Place favicon.ico in the root directory -->

        <!-- Facebook Pixel Code -->
        <script>
            !function (f, b, e, v, n, t, s) {
                if (f.fbq)
                    return;
                n = f.fbq = function () {
                    n.callMethod ?
                            n.callMethod.apply(n, arguments) : n.queue.push(arguments)
                };
                if (!f._fbq)
                    f._fbq = n;
                n.push = n;
                n.loaded = !0;
                n.version = '2.0';
                n.queue = [];
                t = b.createElement(e);
                t.async = !0;
                t.src = v;
                s = b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t, s)
            }(window,
                    document, 'script', '//connect.facebook.net/en_US/fbevents.js');
            fbq('init', '1576695232624762');
            fbq('track', "PageView");
        </script>
    <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=1576695232624762&ev=PageView&noscript=1"/></noscript>
    <!-- End Facebook Pixel Code -->

</head>

<body>
    <div id="whiteHide"></div>
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->

    {{--@include('frontend.includes.nav')--}}

    <!-- div principal -->
    <div id="main">

        @include('frontend.includes.publicsector.header')
        @include('includes.partials.messages')
        @yield('content')

        @include('frontend.includes.publicsector.footer')
    </div>
    <!-- ./div principal -->


    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

    <script>window.jQuery || document.write('<script src="{{asset('js / vendor / jquery - 1.11.2.min.js')}}"><\/script>')</script>

    @yield('before-scripts-end')
    {!! HTML::script(elixir('js/frontend.js')) !!}
    @yield('after-scripts-end')

    @include('includes.partials.ga')

    <script type="text/javascript" async src="https://d335luupugsy2.cloudfront.net/js/loader-scripts/f7b339e6-9aa4-426c-b7d7-84937abd8483-loader.js" ></script>

</body>

</html>
