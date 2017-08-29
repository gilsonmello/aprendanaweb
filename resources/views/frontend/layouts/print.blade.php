<html>
  <head>
    <title>Impressão de Pedido nº .....</title>

    <meta charset="UTF-8">

   {!! HTML::style('css/plugin/bootstrap3-wysihtml5.min.css') !!}
   <!-- ->Colocar lá no elixir<-->
   {!! HTML::style(elixir('css/print.css')) !!}
<!-- ->Colocar lá no elixir<-->
  </head>
  <body>
  @yield('content')
  </body>
  </html>