@extends('frontend.layouts.master')

@section('title')
    Temas em Destaque - Página {{ $videos->currentPage() }} | {{app_name()}}
@endsection

@section('content')

    <section id="main-content">
        <div class="container">
            <section id="search-meaning">
                <h1 class="section-title">Temas em Destaque</h1>
            </section>
        </div>

        <div class="container">

                <div class="col-md-12" style="padding-bottom: 40px;">

                    @foreach($videos as $video)
                            <!-- Inicío Exemplo de Postagem com Coluna maior de foto destacada -->

                    <div class="col-md-3 col-sm-6">
                        <div class="post medium-post">
                            <div class="entry-header">
                                <div class="entry-thumbnail">
                                    <img class="img-responsive" src="{{ imageurl('videos/', $video->id, $video->img, 400, 'generic.png',false) }}" alt="" />
                                </div>
                            </div>
                            <div class="post-content" style="height: 90px; overflow: hidden; text-overflow: ellipsis;">
                                <h2 class="entry-title">
                                    <a href="{{ route("videos.show", [$video->slug]) }}">{{ $video->title }}</a>
                                </h2>
                            </div>
                        </div><!--/post-->
                    </div>

                    @endforeach
                </div>
            <div class="text-center">
                {!! with(new \App\Services\Pagination($videos))->render() !!}
            </div>


        </div>
    </section>


    @include('frontend.includes.ad-footer')

@endsection