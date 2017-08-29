
@extends ('backend.layouts.master')

@section ('title', trans('menus.workshopevaluationgroup_management') . ' | ' . trans('menus.edit_workshopevaluationgroup'))

@section('page-header')
    <h1>
        {{ trans('menus.workshopevaluationgroups') }}
        <small>{{ trans('menus.edit_workshopevaluationgroup') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li>{!! link_to_route('admin.workshopevaluationgroups.index', trans('menus.workshopevaluationgroups')) !!}</li>
    <li class="active">{!! link_to_route('admin.workshopevaluationgroups.create', trans('menus.edit_workshopevaluationgroup')) !!}</li>
@stop

@section('content')

    {!! Form::model($workshopevaluationgroup, ['route' => ['admin.workshopevaluationgroups.update', $workshopevaluationgroup->id], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH']) !!}

    <div class="form-group">
        {!! Form::label('description', trans('strings.description'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('description', null, ['class' => 'form-control', 'placeholder' => trans('strings.description')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('position', trans('crud.workshopevaluationgroups.position'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('position', null, ['class' => 'form-control', 'placeholder' => trans('crud.workshopevaluationgroups.position')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('max_students', trans('crud.workshopevaluationgroups.max_students'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('max_students', null, ['class' => 'form-control', 'placeholder' => trans('crud.workshopevaluationgroups.max_students')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        <label class="col-lg-2 control-label">{{ trans('validation.attributes.active') }}</label>
        <div class="col-lg-1">
            <div class="sw-green create-permissions-switch">
                <div class="onoffswitch">
                    <input type="checkbox" value="1" name="is_active" class="toggleBtn onoffswitch-checkbox" id="course-active" @if($workshopevaluationgroup->is_active == 1)checked="checked"@endif>
                    <label for="course-active" class="onoffswitch-label">
                        <div class="onoffswitch-inner"></div>
                        <div class="onoffswitch-switch"></div>
                    </label>
                </div>
            </div><!--green checkbox-->
        </div>
    </div><!--form control-->

    <div class="pull-left">
            <a href="{{route('admin.workshopevaluationgroups.index', ['page' => Session::get('lastpage', '1')])}}" class="btn btn-danger">{{ trans('strings.cancel_button') }}</a>
        </div>

        <div class="pull-right">
            <input type="submit" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
        </div>
        <div class="clearfix"></div>

    {!! Form::close() !!}
@stop