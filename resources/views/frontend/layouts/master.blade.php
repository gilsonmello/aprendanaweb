<!DOCTYPE html>
<html class="no-js mh-one-sb" lang="pt-BR" prefix="og: http://ogp.me/ns#">
    <head>
        <!-- Google Analytics -->
        <script>
            (function (i, s, o, g, r, a, m) {
                i['GoogleAnalyticsObject'] = r;
                i[r] = i[r] || function () {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
                a = s.createElement(o),
                        m = s.getElementsByTagName(o)[0];
                a.async = 1;
                a.src = g;
                m.parentNode.insertBefore(a, m)
            })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');
        </script>
        <!-- End Google Analytics -->

    <div id="fb-root"></div>
    <script>(function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id))
                return;
            js = d.createElement(s);
            js.id = id;
            js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v2.8";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>


    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="_token" content="{{ csrf_token() }}"/>
    <link rel="profile" href="http://gmpg.org/xfn/11"/>
    <title>@yield('title', app_name())</title>
    <meta name="description" content="@yield('meta-description')"/>
    <meta name="title" content="@yield('meta-title')"/>
    {{--
            <meta name="description" content="O Brasil Jurídico é uma instituição de ensino que oferece aos seus alunos um conteúdo online de excelência para concursos, Exame da OAB e extensão."> --}}

    <meta name="author" content="@yield('author', 'Brasil Jurídico')">
    <meta name="robots" content="follow,noodp"/>
    <link rel="canonical" href="http://198.50.234.157/~brasilju/"/>

    <meta name="twitter:card" content="summary"/>
    <meta name="twitter:description"
          content="O site Brasil Jurídico possui curso preparatório para concursos jurídicos e Exame da OAB, cursos de atualização e pós-graduações em Direito."/>
    <meta name="twitter:title" content="@yield('title', app_name())"/>
    <meta name="twitter:image"
          content="http://198.50.234.157/~brasilju/wp-content/uploads/2016/11/~brasilju_logo_brasil_juridico_cursos_online.png"/>

    <meta property="og:url" content="@yield('og-url')"/>
    <meta property="og:type" content="@yield('og-type')" />
    <meta property="og:title" content="@yield('og-title')" />
    <meta property="og:description" content="@yield('og-description')" />
    <meta property="og:image" content="@yield('og-img')" />

    @yield('meta')


    @yield('before-styles-end')
    {!! HTML::style(elixir('css/frontend.css')) !!}
    @yield('after-styles-end')

    <!-- Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Titillium+Web:400,700' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Signika+Negative:400,300,600,700' rel='stylesheet'
          type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Titillium+Web:400,400italic,600,900,700italic,700,600italic,300italic,200italic,200,300'
          rel='stylesheet' type='text/css'>


    <!-- Icons-->
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
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
    <noscript><img height="1" width="1" style="display:none"
                   src="https://www.facebook.com/tr?id=1576695232624762&ev=PageView&noscript=1"/></noscript>
    <!-- End Facebook Pixel Code -->
</head>

<body>
 
    <div id="whiteHide"></div>

    <div id="scroll-top">
        <span style="line-height: 1.5; font-weight: bold;" title="voltar ao topo">&nbsp;&nbsp;^&nbsp;&nbsp;</span>
    </div>
    <!--[if lt IE 8]>
    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade
        your browser</a> to improve your experience.</p>
    <![endif]-->

    {{--@include('frontend.includes.nav')--}}

    <!-- div principal -->
    @if(session('compliance.cart') === TRUE)
    @include('frontend.includes.compliance.header')
    @else
    @include('frontend.includes.header')
    @endif


    <div id="main">
        @include('includes.partials.messages')
        @yield('content')

        @if(session('compliance.cart') === TRUE)
        @include('frontend.includes.compliance.footer')
        @else
        @include('frontend.includes.footer')
        @endif
    </div>
    <!-- ./div principal -->


    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

    <script>window.jQuery || document.write('<script src="{{asset('js / vendor / jquery - 1.11.2.min.js')}}"><\/script>')</script>

    @yield('before-scripts-end')
    {!! HTML::script(elixir('js/frontend.js')) !!}
    @yield('after-scripts-end')

    @include('includes.partials.ga')

    <script type="text/javascript" async
    src="https://d335luupugsy2.cloudfront.net/js/loader-scripts/f7b339e6-9aa4-426c-b7d7-84937abd8483-loader.js"></script>


    {{-- <script type="text/javascript">
var LHCChatOptions = {};
LHCChatOptions.opt = {widget_height:340,widget_width:300,popup_height:520,popup_width:500};
(function() {
var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
var referrer = (document.referrer) ? encodeURIComponent(document.referrer.substr(document.referrer.indexOf('://')+1)) : '';
var location  = (document.location) ? encodeURIComponent(window.location.href.substring(window.location.protocol.length)) : '';
po.src = '//atendimento.brasiljuridico.com.br/index.php/por/chat/getstatus/(click)/internal/(position)/bottom_right/(ma)/br/(top)/350/(units)/pixels/(leaveamessage)/true/(department)/1/(theme)/1?r='+referrer+'&l='+location;
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
})();
</script> --}}

    <script>
            (function (h, e, a, t, m, p) {
                m = e.createElement(a);
                m.async = !0;
                m.src = t;
                p = e.getElementsByTagName(a)[0];
                p.parentNode.insertBefore(m, p);
            })(window, document, 'script', 'https://u.heatmap.it/log.js');
    </script>

</body>

</html>
