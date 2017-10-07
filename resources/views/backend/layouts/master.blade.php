<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="_token" content="{{ csrf_token() }}" />
        <title>@yield('title', app_name())</title>
        <meta name="description" content="@yield('meta_description', 'Brasil Jurídico')">
        @yield('meta')
        <meta name="author" content="@yield('author', 'IPQ Tecnologia')">


        {!! HTML::style('css/plugin/select2.min.css') !!}
        {!! HTML::style('css/plugin/datepicker3.css') !!}
        {!! HTML::style('css/plugin/bootstrap3-wysihtml5.min.css') !!}
        {!! HTML::style('css/plugin/dataTables.bootstrap.css') !!}
        {!! HTML::style('css/plugin/jquery.dataTables.css') !!}
        {!! HTML::style('css/plugin/bootstrap-colorpicker.min.css') !!}


        @yield('before-styles-end')
        {!! HTML::style(elixir('css/backend.css')) !!}
        @yield('after-styles-end')

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="skin-blue">
        <div class="wrapper">
          @include('backend.includes.header')
          @include('backend.includes.sidebar')

          <!-- Content Wrapper. Contains page content -->
          <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
              @yield('page-header')
              <ol class="breadcrumb">
                @yield('breadcrumbs')
              </ol>
            </section>

            <!-- Main content -->
            <section class="content">
              @include('includes.partials.messages')
              @yield('content')
            </section><!-- /.content -->
          </div><!-- /.content-wrapper -->

            @include('includes.partials.password')
            @include('backend.includes.footer')
        </div><!-- ./wrapper -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="{{asset('js/vendor/jquery-1.11.2.min.js')}}"><\/script>')</script>
        {!! HTML::script('js/bootstrap.min.js') !!}
        {!! HTML::script('js/select2.full.min.js') !!}
        {!! HTML::script('js/bootstrap3-wysihtml5.all.min.js') !!}
        {!! HTML::script('js/bootstrap-datepicker.js') !!}
        {!! HTML::script('js/inputmask.js') !!}
        {!! HTML::script('js/jquery.inputmask.js') !!}
        {!! HTML::script('js/jquery.maskMoney.js') !!}
        {!! HTML::script('js/inputmask.extensions.js') !!}
        {!! HTML::script('js/dataTables.bootstrap.js') !!}
        {!! HTML::script('js/jquery.dataTables.js') !!}
        {!! HTML::script('js/bootstrap-colorpicker.min.js') !!}


        @yield('before-scripts-end')
        {!! HTML::script(elixir('js/backend.js')) !!}
        @yield('after-scripts-end')
    </body>
</html>
