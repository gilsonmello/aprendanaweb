<!DOCTYPE html>
<html class="no-js mh-one-sb" lang="pt-BR" prefix="og: http://ogp.me/ns#">
    <head>

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


    <meta name="robots" content="follow,noodp"/>


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
    @include('frontend.includes.header')



    <div id="main">
        @include('includes.partials.messages')
        @yield('content')

        @include('frontend.includes.footer')

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


</body>

</html>
