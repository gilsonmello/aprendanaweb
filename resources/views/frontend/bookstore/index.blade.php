@extends('frontend.layouts.master')

@section('title')
    {{$title}} | {{app_name()}}
@endsection

@section('content')
    <section id="main-content">
        <section id="search-result">

            <!--
            <div class="container">
                <h1 class="section-title">{{$title}}</h1>
                <div class="space small"></div>

                <div class="section curso-big">
                    <div class="post">
                        <div class="entry-header">
                            <div class="entry-thumbnail">
                                <img class="img-responsive" src="images/brj-06.jpg" alt="" />
                            </div>
                        </div>
                        <div class="post-content">
                            <span class="label-big label-primary">SAAP</span>
                            <h2>
                                <a href="#">Curso em Destaque</a>
                            </h2>
                            <div class="entry-content">
                                <p>Text of the printing and typesetting industry orem Ipsum has been the industry standard dummy text ever since the when an unknown printer took a galley of type and scrambled.</p>
                            </div>
                        </div>
                    </div><!--/post-->
                </div><!--/.section-->
            </div><!--/.container-->

            <div class="container">
                <h1 class="section-title">{{$title}}</h1>
                </div>

            @if (($section != null) && ($section->banner != null) && ($section->banner != ""))
                @include( $section->banner )
                <div class="space small"></div>
            @endif


            <div class="container">
                <div class="section curso-small">
                    <div class="space small"></div>

                @foreach($courses as $index => $course)
                        @if($index % 2 == 0)
                    <div class="row">
                        @endif
                        <div class="col-md-6 col-sm-6">
                            <div class="card">
                                <div class="entry-header">
                                    <div class="entry-thumbnail" style="cursor: pointer" onclick="window.location='/{{ $course->slug }}'">
                                        <a href="book/{{ $course->slug }}"><img class="img-responsive" src="{{ imageurl("courses/", $course->id , $course->featured_img, 0, 'book_home.jpg') }}" alt="" /></a>
                                    </div>
                                </div>
                                <div class="post-content">
                                    <span class="label-small label-primary" style="background-color: {{ $course->subsection->section->color }}">{{ $course->subsection->section->name }}</span>
                                    <h2>
                                        <a href="book/{{ $course->slug }}" title="{{ $course->title }}">{{ str_limit($course->title, 80) }}</a>
                                    </h2>
                                    <div class="entry-content">
                                        <p>{{$course->short_description != null ? $course->short_description : ''}}</p>
                                    </div>
                                    <div class="entry-meta">
                                        @if ($course->final_price == 0.00)
                                            <p><strong  class="label label-success">GRATUITO</strong></p>
                                        @elseif ($course->price != $course->final_price)
                                            <p>De <strike>R$ {{number_format($course->price, 2, ',', '.')}}</strike> Por R$ {{number_format($course->final_price, 2, ',', '.')}}</p>
                                        @else
                                            <p>R$ {{number_format($course->final_price, 2, ',', '.')}}</p>
                                        @endif
                                    </div>
                                </div>
                            </div><!--/.card-->
                        </div><!--/.col-->
                        @if($index % 2 == 1 || $index >= $courses->count() - 1)
                    </div><!--/.row-->
                        @endif
                    @endforeach
                </div><!--/.section-->
            </div><!--/.container-->
            <div class="clearfix"></div>
            <div class="container">
                {!! with(new \App\Services\Pagination($courses))->render() !!}
            </div>
            <div class="space small"></div>


    @include('frontend.includes.ad-footer')
        </section>
    </section>

@endsection