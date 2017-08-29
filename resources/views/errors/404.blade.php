@extends("frontend.layouts.master")
@section('title')
ERROR 404 - Página {{ 404 }}
@endsection

@section('content')

<section id="main-content">
    <div class="container" style="height: 350px">

        <h1 style="text-align:center">404 - {{ trans('strings.page_not_found') }}</h1>
        <p style="text-align:center">{{ trans('strings.sorry_page_you_were_trying') }}</p>

        <!-- IE needs 512+ bytes: http://blogs.msdn.com/b/ieinternals/archive/2010/08/19/http-error-pages-in-internet-explorer.aspx -->
    </div>
</section>
@endsection