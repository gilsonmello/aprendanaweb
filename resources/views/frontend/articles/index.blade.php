@extends('frontend.layouts.master')

@section('title')
 Artigos - Página {{ $articles->currentPage() }} | {{app_name()}}
@endsection

@section('content')
    <div class="section">
        <div class="container">
            <h1 class="section-title">Artigos</h1>
            @foreach($articles as $index => $article)
            @if($index % 2 == 0)
            <div class="space"></div>
            <div class="row">
                @endif
                <div class="col-md-6">
                    <div class="media">
                        <div class="pull-left">
	                                <span class="fa-stack fa-3x">
                                        @if (($article->users != null) && ($article->users->first() != null))
                                            <img class="img-responsive img-circle" src="{{ imageurl('users/', $article->users->first()->id, $article->users->first()->photo, 200, 'generic.png',true) }}" alt="">
                                        @else
                                            <img class="img-responsive img-circle" src="{{ imageurl('users/', '', '', 200, 'generic.png',true) }}" alt="">
                                        @endif
	                                </span>
                        </div>
                        <div class="media-body">
                            <div class="heading-line color-secondary small left"></div>
                            @if (($article->users != null) && ($article->users->first() != null))
                                <h6>{{$article->users->first()->name}}</h6>
                            @else
                                <h6>Autor não informado</h6>
                            @endif
                            <h5><a href="{{ route("articles.show", [$article->slug]) }}">{{ $article->title }}</a></h5>
                        </div>
                    </div>
                </div><!-- /.col -->
                @if($index %  2 == 1 || $index == $articles->count() - 1)
            </div>
                @endif
                @endforeach
            <div class="space hidden-md- hidden-lg"><br/></div>
            <div class="text-center">
                {!! with(new \App\Services\Pagination($articles))->render() !!}
            </div>
        </div>
    </div>

    @include('frontend.includes.ad-footer')









@endsection