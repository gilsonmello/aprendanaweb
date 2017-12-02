<!doctype html>
<html class="fixed sidebar-light sidebar-left-sm  sidebar-left-collapsed header-light">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="_token" content="{{ csrf_token() }}" />
        <title>@yield('title', app_name())</title>
        <meta name="description" content="@yield('meta_description', 'O Brasil Jur�dico � Ensino de Alta Performance � uma institui��o de ensino que nasceu com o fiel prop�sito e o compromisso �tico de oferecer aos seus alunos e � toda comunidade jur�dica do pa�s um conte�do did�tico arrojado e de excel�ncia, com m�todos e recursos modernos, indispens�veis ao crescimento profissional.')">
        <meta name="author" content="@yield('author', 'Brasil Jur�dico')">
        @yield('meta')
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />

        {!! HTML::style('css/plugin/select2.min.css') !!}
        {!! HTML::style('css/plugin/datepicker3.css') !!}
        {!! HTML::style('css/plugin/bootstrap3-wysihtml5.min.css') !!}
        @yield('before-styles-end')
        {!! HTML::style(elixir('css/classroom.css')) !!}
        @yield('after-styles-end')

        



    </head>
    <body>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        {{--@include('frontend.includes.nav')--}}

        <!-- div principal -->
       
        <section class="body">
            <div id="scroll-top">
                <span style="line-height: 1.5; font-weight: bold;" title="voltar ao topo">
                    &nbsp;&nbsp;^&nbsp;&nbsp;
                </span>
            </div>

        @include(get_classroom_header())
        {{--@include('frontend.includes.classroom-header')--}}

        <div class="inner-wrapper">
                {{--@include('frontend.includes.classroom-sidebar')--}}


                @yield('content')

            @include('frontend.studentarea.requestfailure')
        </div>
        <!-- ./div principal -->









            <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
            <script>window.jQuery || document.write('<script src="{{asset('js/vendor/jquery-1.11.2.min.js')}}"><\/script>')</script>


        {!! HTML::script('js/vendor/bootstrap.min.js') !!}
        {!! HTML::script('js/vendor/select2.full.min.js') !!}
        {!! HTML::script('js/vendor/bootstrap3-wysihtml5.all.min.js') !!}
        {!! HTML::script('js/vendor/bootstrap-datepicker.js') !!}
        {!! HTML::script('js/vendor/inputmask.js') !!}
        {!! HTML::script('js/vendor/jquery.inputmask.js') !!}
        {!! HTML::script('js/vendor/jquery.maskMoney.js') !!}
        {!! HTML::script('js/vendor/inputmask.extensions.js') !!}




        @yield('before-scripts-end')
        {!! HTML::script(elixir('js/classroom.js')) !!}
        @yield('after-scripts-end')


    </body>
</html>
