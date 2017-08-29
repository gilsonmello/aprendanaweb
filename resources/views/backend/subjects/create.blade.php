@extends ('backend.layouts.master')

@section ('title', trans('menus.subject_management') . ' | ' . trans('menus.create_subject'))

@section('page-header')
    <h1>
        {{ trans('menus.subject_management') }}
        <small>{{ trans('menus.create_subject') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li>{!! link_to_route('admin.subjects.index', trans('menus.subject')) !!}</li>
    <li class="active">{!! link_to_route('admin.subjects.create', trans('menus.create_subject')) !!}</li>
@stop

@section('content')

    {!! Form::open(['route' => 'admin.subjects.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post']) !!}

        <div class="form-group">
            {!! Form::label('name', trans('validation.attributes.name'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => trans('strings.name')]) !!}
            </div>

        </div><!--form control-->


    <div class="form-group">
        {!! Form::label('parents', trans('validation.attributes.parent'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::select("parents[]",  [''=>''] + $subjects->lists("name","id")->all(), null, ['class' => 'form-control select2' ])  !!}

        </div>
    </div>

    <div class="form-group">
        {!! Form::label('description', trans('strings.description'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => trans('strings.description')]) !!}
        </div>
    </div><!--form control-->

    <div class="pull-left">
            <a href="{{route('admin.subjects.index')}}" class="btn btn-danger">{{ trans('strings.cancel_button') }}</a>
        </div>

        <div class="pull-right">
            <input type="submit" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
        </div>
        <div class="clearfix"></div>




    <div class="clearfix"></div>

    {!! Form::close() !!}
@stop