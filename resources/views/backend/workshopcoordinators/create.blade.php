
@extends ('backend.layouts.master')

@section ('title', trans('menus.workshopcriteria_management') . ' | ' . trans('menus.edit_workshopcriteria'))

@section('page-header')
    <h1>
        {{ trans('menus.workshopcriterias') }}
        <small>{{ trans('menus.edit_workshopcriteria') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li>{!! link_to_route('admin.workshopcriterias.index', trans('menus.workshopcriterias')) !!}</li>
    <li class="active">{!! link_to_route('admin.workshopcriterias.create', trans('menus.edit_workshopcriteria')) !!}</li>
@stop

@section('content')

    {!! Form::open(['route' => 'admin.workshopcoordinators.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post', 'files' => false]) !!}
        {!! Form::hidden('workshopcoordinator_id', $workshop->id ) !!}
        
        <div class="form-group">
            {!! Form::label('description', trans('strings.description'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('description', $workshop->description, ['disabled' => 'disabled', 'class' => 'form-control', 'placeholder' => trans('strings.description')]) !!}
            </div>

        </div><!--form control-->

        <div class="form-group">
            {!! Form::label('teachers', trans('strings.name'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::select('teachers[]', $teachers->lists('name', 'id')->all() , $workshopcoordinators->lists('teacher_id')->all(), ['class' => 'form-control select2', 'multiple' => 'multiple']) !!}
            </div><!-- /.col -->
        </div>
    

    <div class="pull-left">
            <a href="{{route('admin.workshopcoordinators.index', ['page' => Session::get('lastpage', '1')])}}" class="btn btn-danger">{{ trans('strings.cancel_button') }}</a>
        </div>

        <div class="pull-right">
            <input type="submit" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
        </div>
        <div class="clearfix"></div>

    {!! Form::close() !!}
@stop