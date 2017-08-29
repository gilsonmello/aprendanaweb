@extends('frontend.layouts.master')

@section('content')

    <section id="main-content">
        <div class="container">

            <div class="row">
                <div class="col-md-9">

                    @foreach($articles as $article)
                        <!-- Inicío Exemplo de Postagem com Coluna maior de foto destacada -->
                        <article class="item-post">
                            <div class="row">
                                <div class="col-sm-3"><a href="{{ route('articles.show', $article->slug) }}" class=""><img src="http://placehold.it/400x400" class="img-responsive"></a>
                                </div>
                                <div class="col-sm-9">
                                    <span class="item-post-date">{{ $article->date }} <i class="fa fa-circle"></i> Por
                                        @foreach($article->users as $user)
                                            <a href="{{ route('teachers.show', $user->id) }}">{{ $user->name }}</a>
                                        @endforeach
                                    </span>
                                    <a href="{{ route('articles.show', $article->slug) }}">
                                        <h3 class="item-post-title">{{ $article->title }}</h3>

                                        <p class="item-post-description">{{ str_limit(strip_tags($article->content), 200) }}</p>
                                    </a>
                                </div>
                            </div>
                        </article>
                        <hr>
                        <!-- Inicío Exemplo de Postagem com Coluna maior de foto destacada -->
                    @endforeach


                    <div class="pull-left">
                        {!! with(new \App\Services\Pagination($articles))->render() !!}
                    </div>
                </div>
            </div>

        </div>
    </section>

@endsection