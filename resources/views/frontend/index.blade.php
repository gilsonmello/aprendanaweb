@extends('frontend.layouts.master')

@section('content')

{{--@include('frontend.home.video')--}}
{{--@include('frontend.home.section-menu')--}}

<div id="main-wrapper" class="page" >
    <div style="margin-top: 0px;">

        {{--@include('frontend.home.reta-final-essencial') --}}
        {{--@include('frontend.home.ce')--}}

        @include('frontend.home.banners')


        {{-- @include('frontend.home.cpc') --}}
        {{--@include('frontend.home.cpc-trabalho')--}}
        {{--@include('frontend.home.dpe')--}}
        {{--@include('frontend.home.featured-courses')--}}

        {{--@include('frontend.home.eleicoes')--}}

        {{-- @include('frontend.home.saaps') --}}

        {{-- @include('frontend.includes.exams-discount') --}}

        {{--@include('frontend.home.saaps-list')--}}

        <div class="space"></div>
        
        @foreach($coursesCategorySet as $coursesCategory)

        @if ($coursesCategory != null)
        @include('frontend.home.courses-from-category')
        @endif

        @endforeach

        @include('frontend.home.news')
        {{--@include('frontend.home.articles')--}}

        <div class="space small"></div>

        {{--@include('frontend.home.themes')--}}

        <div class="space small"></div>

        @include('frontend.home.teachers')

        <div class="space small"></div>

        @include('frontend.home.newsletter')

        <div class="space small"></div>

        <div id="white-bg">
            @include('frontend.home.payment-footer')
        </div>
    </div>
</div>
<!--/#main-wrapper-->
@endsection

@section('after-scripts-end')
<script>
    //Being injected from FrontendController
</script>

@stop