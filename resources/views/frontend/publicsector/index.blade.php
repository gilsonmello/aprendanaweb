@extends('frontend.layouts.masterpublicsector')

@section('content')

<div id="main-wrapper" class="page">
    <div class="container">
        <div class="section">
            <div class="row">
                <div class="site-content col-md-12">
                    <!--                        <div class="row">
                                                <div class="col-sm-6" style="width: 100%;">
                                                    <div class="post feature-post">
                                                        <div class="entry-header">
                                                            <div class="entry-thumbnail">
                                                                <a href="/gestaopublica/sobmedida">
                                                                <img class="img-responsive" width="100%" style="cursor: pointer" src="img/frontend/banner_site_10_bolsas.jpg" >
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>-->

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="post feature-post">
                                <div class="entry-header">
                                    <div class="entry-thumbnail">
                                        {{--  <img class="img-responsive" style="cursor: pointer" onclick="window.location='https://www.brasiljuridico.com.br/novo-cpc-o-que-mudou-curso-completo'" src="/img/frontend/banner_transparencia_publica.jpg" alt=""> --}}
                                        <img class="img-responsive" style="cursor: pointer" onclick="window.location = '/gestaopublica/curso/transparencia'"  src="/img/frontend/gestaopublica/banner_transparencia.jpg" alt="">
                                    </div>
                                </div>{{-- Remoção da borda preta abaixo das imagens 
                                    <div class="post-content2">
                                        <h2 class="entry-title">
                                        </h2>
                                    </div> --}}
                            </div><!--/post-->
                        </div><!--/.col-->
                        <div class="col-sm-6">
                            <div class="post feature-post">
                                <div class="entry-header">
                                    <div class="entry-thumbnail">
                                        <iframe src="https://player.vimeo.com/video/201030908?title=0&amp;byline=0&amp;portrait=0&amp;badge=0&amp;color=ffffff"
                                                width="100%" height="340" frameborder="0"
                                                webkitAllowFullScreen mozallowfullscreen allowFullScreen>
                                        </iframe>
                                    </div>
                                </div>
                            </div><!--/post-->
                        </div><!--/.col-->
                    </div><!--/.row-->

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="post feature-post">
                                <div class="entry-header">
                                    <div class="entry-thumbnail">
                                        <a href="/gestaopublica/curso/prestacao-de-contas-e-a-fiscalizacao-nos-municipios-prinscipais-irregularidades-que-causam-a-rejeicao-de-contas">
                                            <img class="img-responsive" src="/img/frontend/gestaopublica/breve_municipio.jpg" alt="">
                                        </a>
                                    </div>
                                </div>
                                {{-- Remoção da borda preta abaixo das imagens <div class="post-content2">
                                        <h2 class="entry-title">
                                        </h2>
                                    </div> --}}
                            </div><!--/post-->
                        </div><!--/.col-->
                        <div class="col-sm-6">
                            <div class="post feature-post">
                                <div class="entry-header">
                                    <div class="entry-thumbnail">
                                        <a href="/gestaopublica/curso/camara-de-vereadores-competencia-principios-funcoes-e-processos-legislativos">
                                            <img class="img-responsive" src="/img/frontend/gestaopublica/breve_vereadores.jpg" alt="">
                                        </a>
                                    </div>
                                </div>
                                {{-- Remoção da borda preta abaixo das imagens <div class="post-content2">
                                        <h2 class="entry-title">
                                        </h2>
                                    </div> --}}
                            </div><!--/post-->
                        </div><!--/.col-->
                    </div><!--/.row-->

                </div><!--/#content-->
            </div><!--/.row-->
        </div><!--/.section-->
    </div>

    <div class="space"></div>

    {{--@foreach($coursesCategorySet as $coursesCategory)--}}

    {{--@if ($coursesCategory != null)--}}
    {{--@include('frontend.home.courses-from-category')--}}
    {{--@endif--}}

    {{--@endforeach--}}


    <div class="space small"></div>

    <div id="white-bg">
        <div class="container">
            <div class="page-breadcrumbs" style="margin-top:10px; margin-bottom: 0px">
                <a href="{{ route("publicsector.news") }}"><h1 class="section-title title">Notícias</h1></a>
                <div class="world-nav cat-menu">
                    <ul class="list-inline">
                        <li><a href="{{ route("publicsector.news") }}"><strong>Mais Notícias</strong></a></li>
                    </ul>
                </div>
            </div>
            <div class="row">
                @foreach($news->take(2) as $new)
                <div class="col-md-4">

                    <div class="noticiacard">
                        <div class="entry-header">
                            <div class="entry-thumbnail">
                                <img class="img-responsive" src="{{ imageurl('news/', $new->id, $new->img, 400, 'generic.png',false) }}" alt="" />
                            </div>
                        </div>
                        <div class="noticiacard-content">
                            <div class="entry-date">
                                <span class="publish-date"> {{  $new->date }}</span>
                            </div>
                            <h2 class="title">
                                <a href="{{ route("publicsector.news.show", [$new->slug]) }}">{{ $new->title }}</a>
                            </h2>
                        </div>
                    </div>
                </div>
                @endforeach
                <div class="col-md-4">
                    @foreach($news->splice(2)->take(3) as $new)
                    <div class="noticia">
                        <div class="entry-date">
                            <span class="publish-date"> {{  $new->date }}</span>
                        </div>
                        <h4>
                            <a href="{{ route("publicsector.news.show", [$new->slug]) }}">{{ $new->title }}</a>
                        </h4>
                    </div>

                    @endforeach
                </div><!--/.col-->
            </div><!--/.row-->
        </div><!--/.container-->
    </div><!--/.white-bg-->

    <div class="space small"></div>

    <div id="section"  style="padding-bottom: 20px">
        <div class="container">
            <div class="page-breadcrumbs" style="margin-top:0px; margin-bottom: 0px">
                <a href="{{ route("publicsector.teachers") }}"><h1 class="section-title">Professores Associados</h1></a>
                <div class="world-nav cat-menu">
                    <ul class="list-inline">
                        <li><a href="{{ route("publicsector.teachers") }}"><strong>Todos os Professores</strong></a></li>
                    </ul>
                </div>
            </div>
            <div class="row">
                @foreach($teachers as $teacher)
                <div class="col-sm-2 col-xs-6">
                    <a href="{{ route("publicsector.teacher", [$teacher->idOrSlug()]) }}">
                        <div class="post feature-post">
                            <div class="entry-thumbnail">
                                <img class="img-responsive" src="{{ imageurl('users/', $teacher->id, $teacher->photo, 200, 'generic.png',true) }}" alt="" />
                            </div>
                            <div class="post-content2">
                                <h2 class="entry-title" style="color: white;">
                                    {{ $teacher->name }}
                                </h2>
                            </div>
                        </div><!--/post-->
                    </a>
                </div><!--/.col-->
                @endforeach
            </div><!--/.row -->
        </div><!--/.container -->
    </div><!--/.section -->


    <div id="white-bg">
        @include('frontend.home.payment-footer')
    </div>
</div>
<!--/#main-wrapper-->
@endsection

@section('after-scripts-end')
<script>
    //Being injected from FrontendController
</script>

@stop
