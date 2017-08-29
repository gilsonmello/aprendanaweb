
    <div class="section">
        <div class="container">
            <h1 class="section-title">{{  $coursesCategory->first()->subsection->section->name}}</h1>
            <div class="row">
                <div class="col-md-6">
                    <div class="post">
                        @if($newsSecondCategory->count() == 0)
                            <div class="entry-header">
                                <div class="entry-thumbnail embed-responsive embed-responsive-16by9">
                                    <iframe class="embed-responsive-item" src="{{ $coursesCategory->first()->video_ad_url }}" allowfullscreen></iframe>
                                </div>
                            </div>

                            <div class="post-content">
                                <h1 class="entry-title-big">
                                    <a href="/{{ $coursesCategory->first()->slug }}" title="{{ $coursesCategory->first()->title  }}">
                                        {{ str_limit($coursesCategory->first()->title, 80) }}
                                    </a>
                                </h1>
                                <div class="entry-content">
                                    <p style="overflow: hidden; max-width: 120ch">{{ substr($coursesCategory->first()->description,0,200) . '...' }}</p>
                                </div>
                                <div class="entry-meta">
                                    <p>R$ {{ number_format($coursesCategory->first()->final_price, 2, ',', '.') }} </p>
                                </div>
                            </div>
                        @else

                            <div class="entry-header">
                                @if($news->first()->video != null)
                                    <div class="entry-thumbnail embed-responsive embed-responsive-16by9">
                                        <iframe class="embed-responsive-item" src="{{ $news->first()->video }}" allowfullscreen></iframe>
                                    </div>
                                @else
                                    <div class="entry-thumbnail">
                                        <img class="img-responsive" src="{{ imageurl("news/", $news->first()->id , $news->first()->img, 0, 'course_home.jpg') }}" alt="" />
                                    </div>
                                @endif
                            </div>

                            <div class="post-content">
                                <h1 class="entry-title-big">
                                    <a href="{{ route('news.show',[$newsSecondCategory->first()->slug]) }}">{{ str_limit($newsSecondCategory->first()->title, 80) }}</a>
                                </h1>
                            </div>
                            <div class="list-post">
                                <ul>
                                    @foreach($newsSecondCategory->reverse()->take(2) as $new)
                                        <li>
                                            <a href="{{ route('news.show',[$new->slug])  }}">
                                                {{ $new->title }} <i class="fa fa-angle-right"></i>
                                            </a>

                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                    </div><!--/.post-->
                </div><!--/.col-->

                <div class="col-md-6">
                    <div class=" curso-hor-section"><div class="space"></div>
                        @foreach($coursesCategory->reverse()->take(3) as $course)
                            <div class="post small-post">
                                <div class="entry-header">
                                    <div class="entry-thumbnail" style="cursor: pointer" onclick="window.location='/{{ $course->slug }}'">
                                        <img class="img-responsive" src="{{ imageurl("courses/", $course->id , $course->featured_img, 0, 'course_home.jpg') }}" alt="" />
                                    </div>
                                </div>
                                <div class="post-content">
                                    <span class="label-small label-primary" style="background-color: {{ $course->subsection->section->color }}">{{ $course->subsection->section->name }}</span>
                                    <h3 class="entry-title-big">
                                        <a href="/{{ $course->slug }}" title="{{ $course->title }}">{{ str_limit($course->title, 80) }}</a>
                                    </h3>
                                    <div class="entry-content">
                                        <p>{{ $course->short_description != null ? $course->short_description : ''}}</p>
                                    </div>
                                    <div class="entry-meta">
                                        <p>R$ {{number_format($course->final_price, 2, ',', '.')}} </p>
                                    </div>
                                </div>
                            </div><!--/post-->
                        @endforeach
                    </div><!--/.section curso-hor-section -->
                </div><!--/.col -->
            </div><!--/.row -->
        </div><!--/.container-->
    </div><!--/.section-->
