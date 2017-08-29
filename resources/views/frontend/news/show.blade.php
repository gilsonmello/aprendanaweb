@extends('frontend.layouts.master')

{{-- Meta tags do facebook --}}
@section('meta-description', $news->title)

@section('og-type', 'website')

@section('og-url', route("news.show", [$news->slug]))

@section('og-title', $news->title)

@section('og-description', str_replace(array("\r\n", "\n", "\r", "\t", "\t\t", "\t\t\t"), '', substr(strip_tags($news->content), 0, 200)))

@section('og-img', 'https://brasiljuridico.com.br/'.imageurl('news/', $news->id, $news->img, 400, 'generic.png', false))
{{-- Fim meta tags do facebook --}}

@section('title')
{{ $news->title }} | {{app_name()}}
@endsection

@section('content')

<div class="container">
    <div class="section">
        <div class="row">
            <div class="col-sm-9">
                <div class="details-news">
                    <div class="post">
                        <div class="post-content">
                            <div class="entry-meta">
                                <ul class="list-inline">
                                    <li class="publish-date"><a href="#"> {{ $news->date }} </a></li>
                                </ul>
                            </div>
                            <h1 class="entry-title">
                                {{ $news->title }}
                            </h1>
                            <div class="entry-content">
                                {!! $news->content !!}
                            </div>
                            <br/>
                            <!-- Load Facebook SDK for JavaScript -->
                            <div id="fb-root"></div>
                            <script>(function (d, s, id) {
                                    var js, fjs = d.getElementsByTagName(s)[0];
                                    if (d.getElementById(id))
                                        return;
                                    js = d.createElement(s);
                                    js.id = id;
                                    js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v2.8&appId=1650169501913609";
                                    fjs.parentNode.insertBefore(js, fjs);
                                }(document, 'script', 'facebook-jssdk'));</script>

                            <!-- Your share button code -->
                            <div class="row col-sm-12">


                            </div>
                            <div class="container">
                                <div class="row">
                                    <div class="col-sm-6"> 
                                        <div class="fb-share-button" data-href="{{route("news.show", [$news->slug])}}" data-layout="button" data-size="large" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fwww.brasiljuridico.com.br%2Fnews%2Ftest&amp;src=sdkpreparse">Compartilhar</a></div> </div>
                                    <div class="col-sm-6">
                                        <!--                                        <div class="esconde-Botoes">
                                                                                    <a href="whatsapp://send?text=Acesse o nosso site: {{route("news.show", [$news->slug])}}">
                                                                                        <img src="/img/frontend/whats_ico.png" width="30" height="30"></a><br/>
                                        
                                                                                    <a href="whatsapp://send?text=Veja o produto 'Teste'. Segue o link: http://lvfc.co/l" target="_blank">
                                                                                        <img src="/svg/tiger.svg" width="35" height="35" border="0" alt="Recomende este produto pelo WhatsApp" title="Recomende este produto pelo WhatsApp"></a>
                                        
                                                                                </div>
                                        -->
                                    </div>
                                </div>
                            </div>



                        </div><!--/post-content-->
                    </div><!--/post-->
                </div><!--/details-news-->
            </div><!--/.col-->


            <div class="col-sm-3">

                @foreach($more_packages as $package)
                <div class="post feature-post">
                    <div class="entry-header">
                        <div class="entry-thumbnail">
                            <a href="{{ route('packages.show', [$package->slug]) }}"><img class="img-responsive" src="{{ imageurl("packages/", $package->id , $package->featured_img, 0, 'course_home.jpg') }}" alt="" /></a>
                        </div>
                    </div>
                    <div class="post-content2">
                        <h2 class="entry-title">
                            <a href="{{ route('packages.show', [$package->slug]) }}">R$ {{ $package->final_price }} </a>
                        </h2>
                    </div>
                </div><!--/post-->

                @endforeach

            </div><!--/.col-->






            <div class="col-sm-3">

                @foreach($more_courses as $course)
                <div class="post feature-post">
                    <div class="entry-header">
                        <div class="entry-thumbnail">
                            <a href="{{ route('course-section', ['cursinhos',$course->subsection->section->slug, $course->slug]) }}"><img class="img-responsive" src="{{ imageurl("courses/", $course->id , $course->featured_img, 0, 'course_home.jpg') }}" alt="" /></a>
                        </div>
                    </div>
                    <div class="post-content2">
                        <h2 class="entry-title">
                            <a href="{{ route('course-section', ['cursinhos',$course->subsection->section->slug, $course->slug]) }}">R$ {{ $course->final_price }} </a>
                        </h2>
                    </div>
                </div><!--/post-->

                @endforeach

            </div><!--/.col-->


        </div><!--/.row-->
    </div><!--/.section-->
</div><!--/.container-->


<div class="container">
    <div class="section">
        <h1 class="section-title">Mais notícias</h1>
        <div class="space small"></div>
        <div class="row">


            @foreach($more_news as $more)

            <div class="col-md-4">
                <div class="noticiacard">
                    <div class="entry-header">
                        <div class="entry-thumbnail">
                            <img class="img-responsive" src="{{ imageurl('news/', $more->id, $more->img, 400, 'generic.png',false) }}" alt=""  />
                        </div>
                    </div>
                    <div class="noticiacard-content">
                        <div class="entry-date">
                            <span class="publish-date"> {{ $more->date }}</span>
                        </div>
                        <h2 class="title">
                            <a href="{{ route('news.show',[$more->slug])  }}">{{ $more->title }}</a>
                        </h2>

                    </div>

                </div><!--/post-->
            </div>

            @endforeach
        </div>
    </div><!--/.section -->
</div><!--/.container -->




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
