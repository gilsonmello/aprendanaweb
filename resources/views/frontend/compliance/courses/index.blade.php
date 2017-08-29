@extends('frontend.layouts.masterpublicsector')

@section('title')
    {{$title}} - P�gina {{ $courses->currentPage() }} | {{app_name()}}
@endsection

@section('content')
    <section id="main-content">
        <section id="search-result">


            <div class="container">
                <h1 class="section-title">{{$title}}</h1>
                <div class="space small"></div>
                </div>

            @if (($section != null) && ($section->banner != null) && ($section->banner != ""))
                @include( $section->banner )
            @endif

            <div class="container tag-cloud">
                {{--@foreach($tags as $tag => $count)--}}
                    {{--@if($tag !== "")--}}

                        {{--<a href="{{ route('course-section',["slug" => $slug,"tag" => $tag]) }}" class="label-small label-primary tag-cloud-item {{ $active == $tag ? "selected" : "" }}" style="background-color: {{ $color }}; font-size: {{ min(8 + ($count / 4.5),16.4) }}pt;">{{$tag}}</a>--}}
                    {{--@endif--}}
                {{--@endforeach--}}

                    @if (count($tags) != 0)
                    <div class="row" style="padding-left: 30px;">
                        <div class="row">
                            <div class="col-md-6" style="background-color: #1E376D; padding-left: 30px;  ">
                            <span style="color: white"> Selecione e Compre ++</span>
                            </div>
                        </div>
                        <div class="row">

                        <div class="col-md-6" style="background-color: #1E376D; padding-bottom: 10px; ">
                            <form method="get" action="{{ route('publicsector.courses', ["slug" => $slug])  }}" >
                                <div class="col-md-9 "  >
                                    <select name="tag" id="tag" class="form-control">
                                        <option value="">Cursos e Temas</option>
                                        @foreach($tags as $tag => $count)
                                            @if($tag !== "")
                                                <option value="{{ $tag }}" {{ $tag == $active ? "selected" : "" }}>{{ $tag }} </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 "  >
                                    <button type="submit" class="btn btn-primary btn-block"  style="background-color: #4d71af;"><i class="fa fa-search"></i></button>
                                </div>
                            </form>
                        </div>
                        </div>
                    </div>
                    @endif

            </div>

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
                                    <div class="entry-thumbnail" style="cursor: pointer" onclick="window.location='/gestaopublica/curso/{{ $course->slug }}'">
                                        <a href="/gestaopublica/curso/{{ $course->slug }}"><img class="img-responsive" src="{{ imageurl("courses/", $course->id , $course->featured_img, 0, 'course_home.jpg') }}" alt="" /></a>
                                    </div>
                                </div>
                                <div class="post-content">
                                    <span class="label-small label-primary" style="background-color: {{ $course->subsection->section->color }}">{{ $course->subsection->section->name }}</span>
                                    <h2>
                                        <a href="/gestaopublica/curso/{{ $course->slug }}" title="{{ $course->title }}">{{ str_limit($course->title, 80) }}</a>
                                    </h2>
                                    <div class="entry-content">
                                        <p>{{$course->short_description != null ? $course->short_description : ''}}</p>
                                    </div>
                                    <div class="entry-meta">
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












            {{--@include('frontend.includes.ad-footer')--}}

        </section>
    </section>


@endsection