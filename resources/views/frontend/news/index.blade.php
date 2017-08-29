@extends('frontend.layouts.master')

@section('title')
Notícias - Página {{ $news->currentPage() }} | {{app_name()}}
@endsection

@section('content')

<section id="main-content">

    <!-- Load Facebook SDK for JavaScript -->
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v2.8&appId=1650169501913609";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

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
                        <a href="{{ route("news.show", [$featureds->first()->slug]) }}">{{ $featureds->first()->title }}</a>
                    </h2>
                    <div class="entry-content">
                        <p>{{ str_limit(strip_tags($featureds->first()->content), 200) }}</p>
                    </div>

                    <!-- Your share button code -->
                    <div class="fb-share-button" data-href="{{route("news.show", [$featureds->first()->slug])}}" data-layout="button" data-size="large" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fwww.brasiljuridico.com.br%2Fnews%2Ftest&amp;src=sdkpreparse">Compartilhar</a></div>

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
                            <a href="{{ route("news.show", [$featured->slug]) }}">{{ $featured->title }}</a>
                        </h2>
                     <!-- Your share button code -->
                    <div class="fb-share-button" data-href="{{route("news.show", [$featured->slug])}}" data-layout="button" data-size="large" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fwww.brasiljuridico.com.br%2Fnews%2Ftest&amp;src=sdkpreparse">Compartilhar</a></div>
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
                        <a href="{{ route("news.show", [$new->slug]) }}">{{ $new->title }}</a>
                    </h4>
                </div>
                @endforeach
            </div><!--/.col-->
        </div><!--/.row-->
    </div><!--/.container-->

    <div class="space"></div>
    <div class="container">
        <div class="row">

            <div class="col-md-6">
                @for($i=0;$i< 5;$i++)
                <div class="noticia">
                    <div class="entry-date">
                        <span class="publish-date">{{$news[$i]->date}}</span>
                    </div>
                    <h4>
                        <a href="{{ route("news.show", [$news[$i]->slug]) }}">{{ $news[$i]->title }}</a>
                    </h4>
                </div>

                @endfor
            </div>


            <div class="col-md-6">
                @for($i=5;$i<10;$i++)
                <div class="noticia">
                    <div class="entry-date">
                        <span class="publish-date">{{$news[$i]->date}}</span>
                    </div>
                    <h4>
                        <a href="{{ route("news.show", [$news[$i]->slug]) }}">{{ $news[$i]->title }}</a>
                    </h4>
                </div>

                @endfor
            </div>
        </div>
        <div class="clearfix"><br/></div>
        <div class="pull-left">
            {!! with(new \App\Services\Pagination($news))->render() !!}
        </div>
    </div><!--/.container-->
</section>

@include('frontend.includes.ad-footer')

@endsection