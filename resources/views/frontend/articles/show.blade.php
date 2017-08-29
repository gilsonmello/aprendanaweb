@extends('frontend.layouts.master')

@section('meta-description', $article->title)

{{-- Meta tags do facebook --}}
@section('meta-description', $article->title)

@section('og-type', 'website')

@section('og-url', route("articles.show", [$article->slug]))

@section('og-title', $article->title)

@section('og-description', str_replace(array("\r\n", "\n", "\r", "\t", "\t\t", "\t\t\t"), '', substr(strip_tags($article->content), 0, 200)))

@section('og-img', 'https://www.brasiljuridico.com.br/img/frontend/Logo_Brasil_Juridico_Cursos_Online.png')
{{-- Fim meta tags do facebook --}}

@section('title')
    {{ $article->title }} | {{app_name()}}
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
        <div class="section">
            <div class="row">
                <div class="col-sm-9">
                    <div class="details-news">
                        <div class="post">
                            <div class="post-content">
                                <div class="entry-meta">
                                    <ul class="list-inline">
                                        <li class="publish-date"><a href="#"> {{ $article->date }} </a></li>
                                    </ul>
                                </div>
                                <h1 class="entry-title">
                                    {{ $article->title }}
                                </h1>
                                <div class="entry-content">
                                    {!! $article->content !!}
                                    <!-- Botão do facebook -->
                                    <!-- Your share button code -->
                                    {{-- <div class="fb-share-button" data-href="{{route("articles.show", [$article->slug])}}" data-layout="button" data-size="large" data-mobile-iframe="true">
                                        <a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fwww.brasiljuridico.com.br%2Fnews%2Ftest&amp;src=sdkpreparse">Compartilhar</a> --}}
                                    </div>
                                </div>
                            </div><!--/post-content-->
                        </div><!--/post-->
                    </div><!--/details-news-->
                    <div class="col-sm-3">
                        @foreach($more_courses as $course)
                            <div class="post feature-post">
                                <div class="entry-header">
                                    <div class="entry-thumbnail">
                                        <a href="{{ route('course-section',['cursinhos', $course->section_slug, $course->slug]) }}"><img class="img-responsive" src="{{ imageurl("courses/", $course->id , $course->featured_img, 0, 'course_home.jpg') }}" alt="" /></a>
                                    </div>
                                </div>
                                <div class="post-content2">
                                    <h2 class="entry-title">
                                        <a href="{{ route('course-section',['cursinhos',$course->section_slug,$course->slug]) }}">R$ {{ number_format(getFinalPrice($course), 2, ',', '.') }} </a>
                                    </h2>
                                </div>
                            </div><!--/post-->
                        @endforeach
                    </div><!--/.col-->


                    <div class="clearfix"></div>
                    <hr class="divisor blue">

                    @foreach($article->users as $user)
                    <div class="author">
                        <a href="{{ route('teachers.show', [$user->idOrSlug()]) }}" title="{{ $user->name }}">
                            <div class="col-md-3"><img src="{{ imageurl("users/", $user->id, $user->photo, 200) }}" class="img-responsive"></div>
                            <div class="col-md-9">
                                <h3 class="author-name">{{ $user->name }}</h3>
                                <p>{!! nl2br($user->resume) !!}</p>
                            </div>
                        </a>
                        <div class="clearfix"></div>
                    </div>
                    @endforeach

                </div><!--/.col-->
                
            </div><!--/.row-->
        </div><!--/.section-->
    </div><!--/.container-->


    @if (count($more_articles) != 0)
    <div class="container">
        <div class="section">
            <h1 class="section-title">Outros artigos desse professor</h1>
            <div class="space small"></div>
            <div class="row">


                @foreach($more_articles as $more)

                <div class="col-md-4">
                    <div class="noticiacard">
                        <div class="noticiacard-content">
                            <div class="entry-date">
                                <span class="publish-date"> {{ $more->date }}</span>
                            </div>
                            <h2 class="title">
                                <a href="{{ route("articles.show", [$more->slug]) }}">{{ $more->title }}</a>
                            </h2>
                        </div>
                    </div><!--/post-->
                </div>

                @endforeach
            </div>
        </div><!--/.section -->
    </div><!--/.container -->
    @endif

    @include('frontend.includes.ad-footer')



</section>



@endsection

@section('after-scripts-end')

<script>
    !function (f, b, e, v, n, t, s) {
        if (f.fbq)
            return;
        n = f.fbq = function () {
            n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
        };
        if (!f._fbq)
            f._fbq = n;
        n.push = n;
        n.loaded = !0;
        n.version = '2.0';
        n.queue = [];
        t = b.createElement(e);
        t.async = !0;
        t.src = v;
        s = b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t, s)
    }(window,
            document, 'script', '//connect.facebook.net/en_US/fbevents.js');
    fbq('track', 'ViewContent');
</script>
<noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=1576695232624762&ev=PageView&noscript=1"/></noscript>

@stop

