@extends('frontend.layouts.masterpublicsector')

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
                                </div><!--/post-content-->
                            </div><!--/post-->
                        </div><!--/details-news-->
                    </div><!--/.col-->




                    <div class="col-sm-3">

                        @foreach($more_courses as $course)
                        <div class="post feature-post">
                            <div class="entry-header">
                                <div class="entry-thumbnail">
                                    <a href="{{ route('course-section', [$course->slug]) }}"><img class="img-responsive" src="{{ imageurl("courses/", $course->id , $course->featured_img, 0, 'course_home.jpg') }}" alt="" /></a>
                                </div>
                            </div>
                            <div class="post-content2">
                                <h2 class="entry-title">
                                    <a href="{{ route('course-section', [$course->slug]) }}">R$ {{ $course->final_price }} </a>
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
                                        <a href="{{ route('publicsector.news.show',[$more->slug])  }}">{{ $more->title }}</a>
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
        !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
                n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
            n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
                document,'script','//connect.facebook.net/en_US/fbevents.js');
        fbq('track',  'ViewContent');
    </script>
    <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=1576695232624762&ev=PageView&noscript=1"/></noscript>

@stop
