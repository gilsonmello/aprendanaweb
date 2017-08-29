@extends('frontend.layouts.master')

@section('title')
Resultado da busca | {{app_name()}}
@endsection

@section('content')

<section id="main-content">
    {{--<section id="search-ads">--}}
    {{--<div class="container">--}}
    {{--<img src="http://www.aratuonline.com.br/wp-content/uploads/2014/11/ZEN_SextaGordinho.gif" class="img-responsive">--}}
    {{--</div>--}}
    {{--</section>--}}
    <section id="search-result" style="margin-top:30px;">





        <div class="container">
            <h1 class="section-title">RESULTADO DE BUSCA PARA: <strong style="color: #1E376D;">{{ str_replace( '"', '', $term) }}</strong></h1>
            <div class="section">
                <div class="row">
                    <div class="col-md-3">
                        <div class="space"></div>
                        <ul class="post-list">
                            <li>
                                <div class="post small-post">
                                    <div class="post-content">
                                        <h2 class="entry-title">
                                            <a class="tab-click active" onclick="javascript:$('.tab-click').removeClass('active');
                                                        $(this).addClass('active');
                                                        $('.search-post').css('display', 'none');
                                                        $('.course-post').css('display', 'block');" >CURSOS ({{ count($courses) }})</a>
                                        </h2>
                                        <div class="space small"></div>
                                    </div>
                                </div><!--/post-->
                            </li>
                            <li>
                                <div class="post small-post">
                                    <div class="post-content">
                                        <h2 class="entry-title">
                                            <a  class="tab-click" onclick="javascript:$('.tab-click').removeClass('active');
                                                        $(this).addClass('active');
                                                        $('.search-post').css('display', 'none');
                                                        $('.package-post').css('display', 'block');">SAAP - SIMULADORES ({{ count($packages) }})</a>
                                        </h2>
                                        <div class="space small"></div>
                                    </div>
                                </div><!--/post-->
                            </li>
                            <li>
                                <div class="post small-post">
                                    <div class="post-content">
                                        <h2 class="entry-title">
                                            <a  class="tab-click" onclick="javascript:$('.tab-click').removeClass('active');
                                                        $(this).addClass('active');
                                                        $('.search-post').css('display', 'none');
                                                        $('.video-post').css('display', 'block');">VÍDEOS ({{ count($videos) }})</a>
                                        </h2>
                                        <div class="space small"></div>
                                    </div>
                                </div><!--/post-->
                            </li>
                            <li>
                                <div class="post small-post">
                                    <div class="post-content">
                                        <h2 class="entry-title">
                                            <a class="tab-click" onclick="javascript:$('.tab-click').removeClass('active');
                                                        $(this).addClass('active');
                                                        $('.search-post').css('display', 'none');
                                                        $('.news-post').css('display', 'block');">NOTÍCIAS ({{ count($news) }})</a>
                                        </h2>
                                        <div class="space small"></div>
                                    </div>
                                </div><!--/post-->
                            </li>

                            <li>
                                <div class="post small-post">
                                    <div class="post-content">
                                        <h2 class="entry-title">
                                            <a class="tab-click" onclick="javascript:$('.tab-click').removeClass('active');
                                                        $(this).addClass('active');
                                                        $('.search-post').css('display', 'none');
                                                        $('.teacher-post').css('display', 'block');">PROFESSORES ({{ count($teachers) }})</a>
                                        </h2>
                                        <div class="space small"></div>
                                    </div>
                                </div><!--/post-->
                            </li>
                            <li>
                                <div class="post small-post">
                                    <div class="post-content">
                                        <h2 class="entry-title">
                                            <a class="tab-click" onclick="javascript:$('.tab-click').removeClass('active');
                                                        $(this).addClass('active');
                                                        $('.search-post').css('display', 'none');
                                                        $('.article-post').css('display', 'block');">ARTIGOS ({{ count($articles) }})</a>
                                        </h2>
                                        <div class="space small"></div>
                                    </div>
                                </div><!--/post-->
                            </li>
                        </ul>
                    </div><!--/col-->
                    <div class="col-md-9">
                        @foreach($courses as $course)

                        <div class="post search-post course-post" >
                            <div class="post-content"  style="min-height: 200px;">
                                <div class="space"></div>
                                <div class="col-md-3">
                                    <div class="entry-thumbnail">
                                        <img class="img-responsive" src="{{ imageurl("courses/", $course->id , $course->featured_img, 0, 'course_home.jpg') }}" alt="" />
                                    </div>
                                </div><!--/col-->
                                <div class="col-md-9">
                                    <h2 class="entry-title">
                                        <a href="{{ route('course-section',['cursinhos',$arr_section[$arr_subsection[$course->subsection_id]->section_id]->slug,$course->slug]) }}"> {{ $course->title }} </a>

                                    </h2>
                                    <div class="entry-content">
                                        <p> {{ $course->short_description != null ? $course->short_description : '' }} </p>
                                    </div>
                                    <div class="space"></div>
                                </div><!--/col-->
                            </div><!--/post-content-->
                        </div><!--/post-->
                        @endforeach


                        @foreach($packages as $package)
                        <div class="post search-post package-post" style="display:none;">
                            <div class="post-content" style="min-height: 200px;">
                                <div class="space"></div>
                                <div class="col-md-3">
                                    <div class="entry-thumbnail">
                                        <img class="img-responsive" src="{{ imageurl("packages/", $package->id , $package->featured_img, 0, 'course_home.jpg') }}" alt="" />
                                    </div>
                                </div><!--/col-->
                                <div class="col-md-9">
                                    <h2 class="entry-title">
                                        <a href="{{route('packages.show',[$package->slug])}}">   {{ $package->title }} </a>

                                    </h2>
                                    <div class="entry-content">
                                        <p> {{  $package->short_description != null ? $package->short_description : '' }} </p>
                                    </div>
                                    <div class="space"></div>
                                </div><!--/col-->
                            </div><!--/post-content-->
                        </div><!--/post-->
                        @endforeach

                        @foreach($videos as $video)
                        <div class="post search-post video-post" style="display:none">
                            <div class="post-content"  style="min-height: 200px;">
                                <div class="space"></div>
                                <div class="col-md-3">
                                    <div class="entry-thumbnail">
                                        <img class="img-responsive" src="{{ imageurl("tv-videos/", $video->id , $video->img, 0, 'course_home.jpg') }}" alt="" />
                                    </div>
                                </div><!--/col-->
                                <div class="col-md-9">
                                    <h2 class="entry-title">
                                        <a href="{{ route("videos.show",[$video->slug]) }}">   {{ $video->title }} </a>

                                    </h2>
                                    <div class="entry-content">
                                        <p> {{ str_limit(strip_tags( $video->content ),150) }} </p>
                                    </div>
                                    <div class="space"></div>
                                </div><!--/col-->
                            </div><!--/post-content-->
                        </div><!--/post-->
                        @endforeach




                        @foreach($news as $new)
                        <div class="post search-post news-post" style="display:none">
                            <div class="post-content"  style="min-height: 200px;">
                                <div class="space"></div>
                                <div class="col-md-3">
                                    <div class="entry-thumbnail">
                                        <img class="img-responsive" src="{{ imageurl("news/", $new->id , $new->img, 0, 'course_home.jpg') }}" alt="" />
                                    </div>
                                </div><!--/col-->
                                <div class="col-md-9">
                                    <h2 class="entry-title">
                                        <a href="{{route('news.show',[$new->slug])}}">  {{ $new->title }} </a>

                                    </h2>
                                    <div class="entry-content">
                                        <p> {{ str_limit(strip_tags($new->content),200) }} </p>
                                    </div>
                                    <div class="space"></div>
                                </div><!--/col-->
                            </div><!--/post-content-->
                        </div><!--/post-->
                        @endforeach


                        @foreach($articles as $article)
                        <div class="post search-post article-post" style="display:none">
                            <div class="post-content"  style="min-height: 200px;">
                                <div class="space"></div>
                                <div class="col-md-3">
                                    <span class="fa-stack fa-3x">
                                        @if (($article->users != null) && ($article->users->first() != null))
                                        <img class="img-responsive img-circle" src="{{ imageurl('users/', $article->users->first()->id, $article->users->first()->photo, 200, 'generic.png',true) }}" alt="">
                                        @else
                                        <img class="img-responsive img-circle" src="{{ imageurl('users/', '', '', 200, 'generic.png',true) }}" alt="">
                                        @endif
                                    </span>
                                </div><!--/col-->
                                <div class="col-md-9">
                                    <h2 class="entry-title">
                                        <a href="{{route('articles.show',[$article->slug])}}">     {{ $article->title }} </a>

                                    </h2>
                                    <div class="entry-content">
                                        <p> {{ str_limit(strip_tags($article->content),200) }} </p>
                                    </div>
                                    <div class="space"></div>
                                </div><!--/col-->
                            </div><!--/post-content-->
                        </div><!--/post-->
                        @endforeach


                        @foreach($teachers as $teacher)
                        <div class="post search-post teacher-post" style="display:none">
                            <div class="post-content"  style="min-height: 200px;">
                                <div class="space"></div>
                                <div class="col-md-3">
                                    <div class="entry-thumbnail">
                                        <img class="img-responsive" width="140" src="{{ imageurl("users/", $teacher->id , $teacher->photo, 0, 'generic.png') }}" alt="" />
                                    </div>
                                </div><!--/col-->
                                <div class="col-md-9">
                                    <h2 class="entry-title">
                                        <a href="{{route('teachers.show',$teacher->idOrSlug())}}">    {{ $teacher->name }} </a>

                                    </h2>
                                    <div class="entry-content">
                                        <p> {{ str_limit(strip_tags($teacher->resume),200) }} </p>
                                    </div>
                                    <div class="space"></div>

                                </div><!--/col-->
                            </div><!--/post-content-->
                        </div><!--/post-->
                        @endforeach



                    </div><!--/.row-->
                </div><!--/.section-->
            </div><!--/.container-->


































        </div>

        @include('frontend.includes.ad-footer')
    </section>
</section>

@endsection

@section('after-scripts-end')
<!-- Facebook Pixel Code -->
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
    fbq('track', "Search");
</script>
<noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=1576695232624762&ev=PageView&noscript=1"/></noscript>
<!-- End Facebook Pixel Code -->
@stop
