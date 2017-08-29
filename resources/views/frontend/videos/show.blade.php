@extends('frontend.layouts.master')

@section('meta-description', $video->title)

@section('title')
{{ $video->title }} | {{app_name()}}
@endsection

@section('content')

<!-- Script Facebook -->
<div id="fb-root"></div>
<script>(function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id))
            return;
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v2.4&appId=207871092620321";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
<!-- Script Facebook -->



<section id="main-content">


    <div class="container">
        <div class="section">
            <div class="row">
                <div class="col-sm-9">
                    <div class="details-news">
                        <div class="post">
                            <div class="post-content">
                                <div class="entry-meta">
                                    <ul class="list-inline">
                                        <li class="publish-date"><a href="#"> {{ $video->activation_date }} </a></li>
                                    </ul>
                                </div>
                                <h1 class="entry-title">
                                    {{ $video->title }}
                                </h1>
                                <div class="entry-content">
                                    {!! $video->content !!}
                                </div>

                                @if(!empty($video->url))
                                @if($video->url_frag->vendor == 'youtube')
                                <iframe width="700" height="450"
                                        src="https://www.youtube.com/embed/{{ $video->url_frag->id }}">
                                </iframe>
                                @endif
                                @if($video->url_frag->vendor == 'vimeo')
                                <iframe src="https://player.vimeo.com/video/{{ $video->url_frag->id }}?title=0&amp;byline=0&amp;portrait=0&amp;badge=0&amp;color=ffffff"
                                        width="700" height="450" frameborder="0"
                                        webkitAllowFullScreen mozallowfullscreen allowFullScreen>
                                </iframe>
                                @endif
                                {{--<p>Link: <a href="{{ $video->url }}">{{ $video->url }}</a></p>--}}
                                @endif
                            </div><!--/post-content-->
                        </div><!--/post-->
                    </div><!--/details-news-->



                    <div class="clearfix"></div>
                    <hr class="divisor blue">

                    @foreach($video->users as $user)
                    <div class="author">
                        <a href="{{ route('teachers.show', $user->idOrSlug()) }}" title="{{ $user->name }}">
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
                <div class="col-sm-3">


                    @foreach($more_courses as $course)



                    @if ($course->course != null)
                    {{--/* neste caso, trata-se de um relacionamento com professor, caso contrario, virá da busca por tags /*--}}
                    @if ($course = $course->course )
                        
                    @endif
                    @endif
                    
                 

                    <div class="post feature-post">
                        <div class="entry-header">
                            <div class="entry-thumbnail">
                                <a href="{{ route('course-section', ['cursinhos', $course->section[0]->slug, $course->slug]) }}"><img class="img-responsive" src="{{ imageurl("courses/", $course->id , $course->featured_img, 0, 'course_home.jpg') }}" alt="" /></a>
                            </div>
                        </div>
                        <div class="post-content2">
                            <h2 class="entry-title">
                                <a href="{{ route('course-section', ['cursinhos',$course->section[0]->slug,$course->slug]) }}">R$ {{ number_format($course->final_price, 2, ',', '.') }} </a>
                            </h2>
                        </div>
                    </div><!--/post-->

                    @endforeach

                </div><!--/.col-->
            </div><!--/.row-->
        </div><!--/.section-->
    </div><!--/.container-->


    @if (count($more_videos) != 0)
    <div class="container">
        <div class="section">
            <h1 class="section-title">Outros vídeos desse professor</h1>
            <div class="space small"></div>
            <div class="row">


                @foreach($more_videos as $more)

                <div class="col-md-3 col-sm-6">
                    <div class="post medium-post">
                        <div class="entry-header">
                            <div class="entry-thumbnail">
                                <img class="img-responsive" src="{{ imageurl('tv-videos/', $more->id, $more->img, 400, 'generic.png',false) }}" alt="" />
                            </div>
                        </div>
                        <div class="post-content" style="height: 90px; overflow: hidden; text-overflow: ellipsis;">
                            <h2 class="entry-title">
                                <a href="{{ route("videos.show", [$more->slug]) }}">{{ $more->title }}</a>
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
