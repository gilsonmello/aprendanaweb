@extends ('backend.layouts.master')

@section ('title', trans('menus.newsletters'))

@section('page-header')
    <h1>
        {{ trans('menus.newsletters') }}
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.newsletters.index', trans('menus.newsletters')) !!}</li>
@stop

@section('content')

    <div class="pull-right" style="margin-bottom:10px">
        <a href="{{route('admin.newsletters.index')}}" class="btn btn-primary btn-xs">
            {{ trans('menus.all_newsletters') }}
        </a>
    </div>

    <textarea cols="20" rows="20">
        @foreach ($newsletters as $newsletter)
            {!! $newsletter->email !!},
        @endforeach
        @if(empty(session('f_NewsletterController_campaign_id')) || session('f_NewsletterController_campaign_id') == NULL)
            @foreach ($users as $user)
                {!! $user->email !!},
            @endforeach
        @endif
    </textarea>

    <div class="clearfix"></div>
@stop