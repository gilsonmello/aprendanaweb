@extends ('backend.layouts.master')

@section ('title', trans('menus.subsection_management') . ' | ' . trans('menus.create_subsection'))

@section('page-header')
    <h1>
        {{ trans('menus.subsection_management') }}
        <small>{{ trans('menus.create_subsection') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li>{!! link_to_route('admin.subsections.index', trans('menus.subsection')) !!}</li>
    <li class="active">{!! link_to_route('admin.subsections.create', trans('menus.create_subsection')) !!}</li>
@stop

@section('content')

    {!! Form::open(['route' => ['admin.subsections.store', $sections], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post']) !!}

        <div class="form-group">
            {!! Form::label('name', trans('validation.attributes.name'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('name', null, ['class' => 'form-control title-has-slug', 'placeholder' => trans('strings.name')]) !!}
            </div>

        </div><!--form control-->

    <div class="form-group">
        {!! Form::label('slug', trans('validation.attributes.slug'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('slug', null, ['class' => 'form-control slug-from-title', 'placeholder' => trans('strings.slug')]) !!}
        </div>
    </div><!--form control-->


    <div class="form-group">
        {!! Form::label('sections', trans('validation.attributes.sections'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::select("sections[]",$sections->lists("name","id"), null, ['class' => 'form-control select2', 'placeholder' => trans('strings.choice_subsections') ])  !!}
        </div>
    </div>




    <div class="pull-left">
            <a href="{{route('admin.subsections.index')}}" class="btn btn-danger">{{ trans('strings.cancel_button') }}</a>
        </div>

        <div class="pull-right">
            <input type="submit" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
        </div>
        <div class="clearfix"></div>




    <div class="clearfix"></div>

    {!! Form::close() !!}
@stop