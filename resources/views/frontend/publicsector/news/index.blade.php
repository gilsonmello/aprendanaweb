@extends('frontend.layouts.masterpublicsector')

@section('title')
Notícias - Página {{ $news->currentPage() }} | {{app_name()}}
@endsection

@section('content')

<section id="main-content">
    <div class="container">
        <section id="search-meaning">
            <h1 class="section-title">Notícias</h1>
        </section>

        <div class="space small hidden-md hidden-lg"></div>

        <div class="section curso-big">
            <div class="post">
                <div class="entry-header">
                    <div class="entry-thumbnail">
                        <img class="img-responsive" src="{{ imageurl('news/', $featureds->first()->id, $featureds->first()->img, 0, 'generic.png',false) }}" alt="" />
                    </div>
                </div>

                <div class="post-content">
                    <div class="entry-date">
                        <span class="publish-date"> {{ $featureds->first()->date }}</span>
                    </div>
                    <h2>
                        <a href="{{ route("publicsector.news.show", [$featureds->first()->slug]) }}">{{ $featureds->first()->title }}</a>
                    </h2>
                    <div class="entry-content">
                        <p>{{ str_limit(strip_tags($featureds->first()->content), 200) }}</p>
                    </div>
                </div>
            </div><!--/post-->
        </div><!--/.section-->

        <div class="row">
            @foreach($featureds->splice(-2) as $featured)

            <div class="col-md-4">
                <div class="noticiacard">
                    <div class="entry-header">
                        <div class="entry-thumbnail">
                            <img class="img-responsive" src="{{ imageurl('news/', $featured->id, $featured->img, 400, 'generic.png',false) }}" alt="" />
                        </div>
                    </div>
                    <div class="noticiacard-content">
                        <div class="entry-date">
                            <span class="publish-date">{{ $featured->date }}</span>
                        </div>
                        <h2 class="title">
                            <a href="{{ route("publicsector.news.show", [$featured->slug]) }}">{{ $featured->title }}</a>
                        </h2>
                    </div>
                </div><!--/post-->
            </div>
            @endforeach



            <div class="col-md-4">
                @foreach($news->take(3) as $new)
                <div class="noticia">
                    <div class="entry-date">
                        <span class="publish-date">{{ $new->date }}</span>
                    </div>
                    <h4>
                        <a href="{{ route("publicsector.news.show", [$new->slug]) }}">{{ $new->title }}</a>
                    </h4>
                </div>
                @endforeach
            </div><!--/.col-->
        </div><!--/.row-->
    </div><!--/.container-->




    <div class="clearfix"><br/></div>




    <div class="space"></div>
    <div class="container">
        @foreach($news->splice(2) as $index => $new)
        @if($index % 2 == 0)
        <div class="row">
            @endif
            <div class="col-md-6">
                <div class="noticia">
                    <div class="entry-date">
                        <span class="publish-date">{{ $new->date }}</span>
                    </div>
                    <h4>
                        <a href="{{ route("publicsector.news.show", [$new->slug]) }}">{{ $new->title }}</a>
                    </h4>
                </div>
            </div>
            @if($index % 2 == 1 || $index == $news->splice(2)->count() - 1)
        </div>
        @endif

        @endforeach

        <div class="clearfix"><br/></div>
        <div class="pull-left">
            {!! with(new \App\Services\Pagination($news))->render() !!}
        </div>
    </div><!--/.container-->


</section>


@include('frontend.includes.ad-footer-public-sector')

@endsection