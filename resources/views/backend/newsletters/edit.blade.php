@extends ('backend.layouts.master')

@section ('title', trans('menus.newsletter_management') . ' | ' . trans('menus.create_newsletter'))

@section('page-header')
    <h1>
        {{ trans('menus.newsletters') }}
        <small>{{ trans('menus.edit_newsletter') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li>{!! link_to_route('admin.newsletters.index', trans('menus.newsletters')) !!}</li>
    <li class="active">{!! link_to_route('admin.newsletters.create', trans('menus.edit_newsletter')) !!}</li>
@stop

@section('content')

    {!! Form::model($newsletter, ['route' => ['admin.newsletters.update', $newsletter->id], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH']) !!}

        <div class="form-group">
            {!! Form::label('name', trans('validation.attributes.name'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => trans('strings.title')]) !!}
            </div>
        </div><!--form control-->

        <div class="form-group">
            {!! Form::label('email', trans('validation.attributes.email'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => trans('strings.title')]) !!}
            </div>
        </div><!--form control-->

        <div class="pull-left">
            <a href="{{route('admin.newsletters.index', ['page' => Session::get('lastpage', '1')])}}" class="btn btn-danger">{{ trans('strings.cancel_button') }}</a>
        </div>

        <div class="pull-right">
            <input type="submit" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
        </div>
        <div class="clearfix"></div>

    {!! Form::close() !!}
@stop