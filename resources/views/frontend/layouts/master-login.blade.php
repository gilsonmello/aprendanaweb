<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Faça o seu login | Brasil Jurídico</title>
    <link href='https://fonts.googleapis.com/css?family=Titillium+Web:400,700' rel='stylesheet' type='text/css'>
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

@yield('before-styles-end')
{!! HTML::style(elixir('css/frontend.css')) !!}
@yield('after-styles-end')
@include('includes.partials.messages')
<body style="background:#dadfe1;">
<!-- start: page -->
<section class="body-sign">
    @yield('content')
</section>
<!-- end: page -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="{{asset('js/vendor/jquery-1.11.2.min.js')}}"><\/script>')</script>
{!! HTML::script('js/vendor/bootstrap.min.js') !!}
{!! HTML::script('js/vendor/bootstrap3-wysihtml5.all.min.js') !!}
{!! HTML::script('js/vendor/bootstrap-datepicker.js') !!}


@yield('before-scripts-end')
{!! HTML::script(elixir('js/frontend.js')) !!}
@yield('after-scripts-end')

</body>
</html>