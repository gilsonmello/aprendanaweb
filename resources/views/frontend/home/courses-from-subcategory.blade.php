@if($coursesCategory->count() > 0)
<div class="section no-margin-bottom">
    <div class="container">
        <div class="page-breadcrumbs" style="margin-top:0px; margin-bottom: 0px">
            <a href="{{ $coursesCategory->first()->subsection->slug }}"><h1 class="section-title">{{  $coursesCategory->first()->subsection->name}}</h1></a>
            <div class="world-nav cat-menu">
                <ul class="list-inline">
                    <li><a href="{{ $coursesCategory->first()->subsection->slug }}"><strong>Todos os cursos</strong></a></li>
                </ul>
            </div>
        </div>

        <div class="row"><div class="space small"></div>
            <div class="col-md-6 col-sm-6">
                <div class="card">
                    <div class="post small-post">
                        <div class="entry-header">
                            <div class="entry-thumbnail embed-responsive embed-responsive-16by9">
                                <iframe class="embed-responsive-item" src="{{ $coursesCategory->first()->video_ad_url }}" allowfullscreen></iframe>
                            </div>
                        </div>
                        <div class="post-content">
                            <h1 class="entry-title-big">
                                <a href="{{route('course-section-ga', [$coursesCategory->first()->subsection->section->slug,$coursesCategory->first()->slug])  }}" title="{{$coursesCategory->first()->title}}">
                                    {{ str_limit($coursesCategory->first()->title, 80) }}
                                </a>
                            </h1>
                            <div class="entry-content">
                                <p style="overflow: hidden; max-width: 120ch">{{ $coursesCategory->first()->short_description }}</p>
                            </div>
                            <div class="entry-meta">
                                @if ($coursesCategory->first()->price != $coursesCategory->first()->final_price)
                                <p>De <strike>R$ {{number_format($coursesCategory->first()->price, 2, ',', '.')}}</strike> Por R$ {{number_format($coursesCategory->first()->final_price, 2, ',', '.')}}</p>
                                @else
                                <p>R$ {{ number_format($coursesCategory->first()->final_price, 2, ',', '.') }} </p>
                                @endif
                            </div>
                        </div>
                    </div><!--/.post-->
                </div>
            </div><!--/.col-->




            <div class="col-md-6 col-sm-6">
                <div class="section curso-small">
                    @foreach($coursesCategory->reverse()->take($coursesCategory->count() - 1) as $course)
                    <div class="card">
                        <div class="post small-post">
                            <div class="entry-header">
                                <div class="entry-thumbnail" style="cursor: pointer" onclick="window.location ='{{route('course-section-ga', [$course->subsection->section->slug,$course->slug])  }}'">
                                    <img class="img-responsive" src="{{ imageurl("courses/", $course->id , $course->featured_img, 0, 'course_home.jpg') }}" alt="" />
                                </div>
                            </div>
                            <div class="post-content">
                                <span class="label-small label-primary" style="background-color: {{ $course->subsection->section->color }}">{{ $course->subsection->name }}</span>
                                <h3 class="entry-title-big">
                                    <a href="{{route('course-section-ga', [$course->slug])  }}">{{ str_limit($course->title, 80) }}</a>
                                </h3>
                                <div class="entry-content">
                                    <p>{{ $course->short_description != null ? $course->short_description : ''}}</p>
                                </div>
                                <div class="entry-meta">
                                    @if ($course->price != $course->final_price)
                                    <p>De <strike>R$ {{number_format($course->price, 2, ',', '.')}}</strike> Por R$ {{number_format($course->final_price, 2, ',', '.')}}</p>
                                    @else
                                    <p>R$ {{number_format($course->final_price, 2, ',', '.')}} </p>
                                    @endif
                                </div>
                            </div>
                        </div><!--/post-->
                    </div>
                    @endforeach
                </div><!--/.section curso-hor-section -->
            </div><!--/.col -->
        </div><!--/.row -->
    </div><!--/.container-->
</div><!--/.section-->
<div class="space"></div>
@endif