
<div class="container">
    <div class="page-breadcrumbs" style="margin-top:30px; margin-bottom: 40px">
        <h1 class="section-title">Cursos Online</h1>
        <div class="world-nav cat-menu">
            <ul class="list-inline">
                <li class="active"><a data-toggle="tab" href="#special-offer">Promoções</a></li>
                <li class="active"><a data-toggle="tab" href="#best-selling">Mais Vendidos</a></li>
                <li><a data-toggle="tab" href="#recommended">Melhor Avaliados</a></li>
                <li><a data-toggle="tab" href="#release">Lançamentos</a></li>
            </ul>
        </div>
    </div>
</div><!--/.container-->




<div class="container tab-content">
    <div id="special-offer" class="section curso-small tab-pane fade in active " style="margin-bottom:0">
    <div class="row">

    @if($count_offers = $coursesSpecialOffer->take(6)->count()) @endif
    @foreach($coursesSpecialOffer->take(6) as $index => $course)
    @if($index == 0 || $index == ceil($count_offers / 2.0))

    <div class="col-md-6 col-sm-6">

    @endif
    <div class="card">
    <div class="post small-post">
    <div class="entry-header">
    <div class="entry-thumbnail" style="cursor: pointer" onclick="window.location='/{{ $course->slug }}'">
    <img class="img-responsive" src="{{ imageurl("courses/", $course->id , $course->featured_img, 0, 'course_home.jpg') }}" alt="" />
    </div>
    </div>
    <div class="post-content">
    <span class="label-small label-primary" style="background-color: {{ $course->subsection->section->color }}">{{ $course->subsection->section->name }}</span>

    <h3 class="entry-title-big">
    <a href="/{{ $course->slug }}" title="{{ $course->title  }}">{{ str_limit($course->title, 80) }}</a>
    </h3>
    <div class="entry-content">
    <p>{{$course->short_description != null ? $course->short_description : ''}}</p>
    </div>
    <div class="entry-meta">
    <p>R$ {{number_format($course->final_price, 2, ',', '.')}}</p>
    </div>
    </div>
    </div><!--/post-->
    </div>
    @if($index != 0 && $index %  ceil($count_offers / 2.0) == (ceil($count_offers / 2.0) - 1)    || ($index == $count_offers - 1))
    <!--/.section curso-hor-section -->
    </div><!--/.col -->
    @endif
    @endforeach
    </div><!--/.row -->
    </div><!--/.section-->
    <div id="best-selling" class="section curso-small tab-pane fade in active" style="margin-bottom:0">
        <div class="row">
            @if($count_offers = $coursesBestSelling->take(6)->count()) @endif
            @foreach($coursesBestSelling->take(6) as $index => $course)
                @if($index == 0 || $index == ceil($count_offers / 2.0))

                    <div class="col-md-6 col-sm-6">

                        @endif
                        <div class="card">
                            <div class="post small-post">
                                <div class="entry-header">
                                    <div class="entry-thumbnail" style="cursor: pointer" onclick="window.location='/{{ $course->slug }}'">
                                        <img class="img-responsive" src="{{ imageurl("courses/", $course->id , $course->featured_img, 0, 'course_home.jpg') }}" alt="" />
                                    </div>
                                </div>
                                <div class="post-content">
                                    <span class="label-small label-primary" style="background-color: {{ $course->subsection->section->color }}">{{ $course->subsection->section->name }}</span>

                                    <h3 class="entry-title-big">
                                        <a href="/{{ $course->slug }}" title="{{ $course->title  }}">{{ str_limit($course->title, 80) }}</a>
                                    </h3>
                                    <div class="entry-content">
                                        <p>{{$course->short_description != null ? $course->short_description : '' }}</p>
                                    </div>
                                    <div class="entry-meta">
                                        <p>R$ {{number_format($course->final_price, 2, ',', '.')}}</p>
                                    </div>
                                </div>
                            </div><!--/post-->
                        </div>
                        @if($index != 0 && $index %  ceil($count_offers / 2.0) == (ceil($count_offers / 2.0) - 1)    || ($index == $count_offers - 1))
                                <!--/.section curso-hor-section -->

                    </div><!--/.col -->
                @endif
            @endforeach
        </div><!--/.row -->
    </div><!--/.section-->

                <div id="recommended" class="section curso-small tab-pane fade" style="margin-bottom:0">
                    <div class="row">
                        @if($count_offers = $coursesRecommended->take(6)->count()) @endif
                        @foreach($coursesRecommended->take(6) as $index => $course)
                            @if($index == 0 || $index == ceil($count_offers / 2.0))

                                <div class="col-md-6 col-sm-6">


                                        @endif
                                        <div class="card">
                                        <div class="post small-post">
                                            <div class="entry-header">
                                                <div class="entry-thumbnail" style="cursor: pointer" onclick="window.location='/{{ $course->slug }}'">
                                                    <img class="img-responsive" src="{{ imageurl("courses/", $course->id , $course->featured_img, 0, 'course_home.jpg') }}" alt="" />
                                                </div>
                                            </div>
                                            <div class="post-content">
                                                <span class="label-small label-primary" style="background-color: {{ $course->subsection->section->color }}">{{ $course->subsection->section->name }}</span>

                                                <h3 class="entry-title-big">
                                                    <a href="/{{ $course->slug }}" title="{{ $course->title  }}">{{ str_limit($course->title, 80) }}</a>
                                                </h3>
                                                <div class="entry-content">
                                                    <p>{{ $course->short_description != null ? $course->short_description : '' }}</p>
                                                </div>
                                                <div class="entry-meta">
                                                    <p>R$ {{number_format($course->final_price, 2, ',', '.')}}</p>
                                                </div>
                                            </div>
                                        </div><!--/post-->
                                        </div>
                                        @if($index != 0 && $index %  ceil($count_offers / 2.0) == (ceil($count_offers / 2.0) - 1)    || ($index == $count_offers - 1))
                                    <!--/.section curso-hor-section -->

                                </div><!--/.col -->
                            @endif
                        @endforeach
                    </div><!--/.row -->
                </div><!--/.section-->

    <div id="release" class="section curso-small tab-pane fade" style="margin-bottom:0">
        <div class="row">
            @if($count_offers = $coursesRelease->take(6)->count()) @endif
            @foreach($coursesRelease->take(6) as $index => $course)
                @if($index == 0 || $index == ceil($count_offers / 2.0))

                    <div class="col-md-6">


                        @endif
                        <div class="card">
                            <div class="post small-post">
                                <div class="entry-header">
                                    <div class="entry-thumbnail" style="cursor: pointer" onclick="window.location='/{{ $course->slug }}'">
                                        <img class="img-responsive" src="{{ imageurl("courses/", $course->id , $course->featured_img, 0, 'course_home.jpg') }}" alt="" />
                                    </div>
                                </div>
                                <div class="post-content">
                                    <span class="label-small label-primary" style="background-color: {{ $course->subsection->section->color }}">{{ $course->subsection->section->name }}</span>

                                    <h3 class="entry-title-big">
                                        <a href="/{{ $course->slug }}" title="{{ $course->title  }}">{{ str_limit($course->title, 80) }}</a>
                                    </h3>
                                    <div class="entry-content">
                                        <p>{{ $course->short_description != null ? $course->short_description : ''}}</p>
                                    </div>
                                    <div class="entry-meta">
                                        <p>R$ {{number_format($course->final_price, 2, ',', '.')}}</p>
                                    </div>
                                </div>
                            </div><!--/post-->
                        </div>
                        @if($index != 0 && $index %  ceil($count_offers / 2.0) == (ceil($count_offers / 2.0) - 1)    || ($index == $count_offers - 1))
                                <!--/.section curso-hor-section -->

                    </div><!--/.col -->
                @endif
            @endforeach
        </div><!--/.row -->
    </div><!--/.section-->
</div><!--/.container-->
