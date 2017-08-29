@extends('frontend.layouts.master')

@section('meta-title', $title)

@section('meta-description', "O site Brasil Jurídico possui curso preparatório para concursos jurídicos e Exame da OAB, cursos de atualização e pós-graduações em Direito.")

@section('title')
    {{$title}} - Página {{ $packages->currentPage() }} | {{app_name()}}
@endsection

@section('content')
    <section id="main-content">
        <section id="search-result">

            <div class="container">
                <h1 class="section-title">{{$title}}</h1>
                <div class="space small"></div>
            </div>

            @include('frontend.includes.exams-discount')



            <div class="container tag-cloud" style="padding-top: 15px">
                {{--@foreach($tags as $tag => $count)--}}
                    {{--@if($tag !== "")--}}

                        {{--<a href="{{ route('course-section',["slug" => $slug,"tag" => $tag]) }}" class="label-small label-primary tag-cloud-item {{ $active == $tag ? "selected" : "" }}" style="background-color: {{ $color }}; font-size: {{ min(8 + ($count / 4.5),16.4) }}pt;">{{$tag}}</a>--}}
                    {{--@endif--}}
                {{--@endforeach--}}

                
                @if (count($tags) != 0)
                <div class="row" style="padding-left: 30px;">
                    <div class="row">
                        <div class="col-md-6" style="background-color: white; padding-left: 30px;  ">
                            <span style="color: #1E376D"> <strong>Selecione e Compre</strong></span>
                        </div>
                    </div>
                    <div class="row">
                    <div class="col-md-6" style="background-color: white; padding-bottom: 10px; ">
                        <form method="get" action="{{ route('course-section', ['exame-oab', 'slug' => $slug])  }}" >
                        <div class="col-md-9 "  >
                                <select name="tag" id="tag" class="form-control">
                                <option value="">Todos os SAAPs</option>
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



                @foreach($packages as $index => $package)
                        @if($index % 2 == 0)
                            <div class="row">
                                @endif
                                <div class="col-md-6 col-sm-6">
                                    <div class="card">
                                        <div class="entry-header">
                                            <div class="entry-thumbnail" style="cursor: pointer" onclick="window.location='/{{ $package->slug }}'">
                                                <a href="{{ route('packages.show',[$package->slug ]) }}"><img class="img-responsive" src="{{ imageurl("packages/", $package->id , $package->featured_img, 0, 'course_home.jpg') }}" alt="" /></a>
                                            </div>
                                        </div>
                                        <div class="post-content">
                                            <span class="label-small label-primary" style="background-color: {{ $package->subsection->section->color }}">{{ $package->subsection->section->name }}</span>
                                            <h2>
                                                <a href="{{ route('packages.show',[$package->slug ]) }}">{{ $package->title }}</a>
                                            </h2>
                                            <div class="entry-content">
                                                <p>{{$package->short_description != null ? $package->short_description : ''}}</p>
                                            </div>
                                            <div class="entry-meta">
                                                <p style="margin: 0px !importante;">
                                                @if ($package->final_price == 0.00)
                                                    <strong  class="label label-success">GRATUITO</strong>
                                                @elseif ($package->price != $package->final_price)
                                                    <p>De <strike>R$ {{number_format($package->price, 2, ',', '.')}}</strike> Por R$ {{number_format($package->final_price, 2, ',', '.')}}</p>
                                                @else
                                                    <p>R$ {{number_format($package->final_price, 2, ',', '.')}}</p>
                                                @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div><!--/.card-->
                                </div><!--/.col-->
                                @if($index % 2 == 1 || $index >= $packages->count() - 1)
                            </div><!--/.row-->
                        @endif
                    @endforeach
                </div><!--/.section-->
            </div><!--/.container-->
            <div class="clearfix"></div>
            <div class="container">
                {!! with(new \App\Services\Pagination($packages))->render() !!}
            </div>






            @include('frontend.includes.ad-footer')
        </section>
    </section>


@endsection