
@extends ('backend.layouts.master')

@section ('title', trans('menus.occupation_management') . ' | ' . trans('menus.edit_occupation'))

@section('page-header')
    <h1>
        {{ trans('menus.occupations') }}
        <small>{{ trans('menus.edit_occupation') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li>{!! link_to_route('admin.occupations.index', trans('menus.occupations')) !!}</li>
    <li class="active">{!! link_to_route('admin.occupations.create', trans('menus.edit_occupation')) !!}</li>
@stop

@section('content')

    {!! Form::model($occupation, ['route' => ['admin.occupations.update', $occupation->id], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH']) !!}

        <div class="form-group">
            {!! Form::label('nome', trans('validation.attributes.description'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('description', $occupation->description, ['class' => 'form-control', 'placeholder' => trans('strings.name')]) !!}
            </div>
        </div><!--form control-->

    <div class="pull-left">
            <a href="{{route('admin.occupations.index', ['page' => Session::get('lastpage', '1')])}}" class="btn btn-danger">{{ trans('strings.cancel_button') }}</a>
        </div>

        <div class="pull-right">
            <input type="submit" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
        </div>
        <div class="clearfix"></div>

    {!! Form::close() !!}
@stop