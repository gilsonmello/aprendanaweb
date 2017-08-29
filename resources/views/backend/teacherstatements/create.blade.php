@extends ('backend.layouts.master')

@section ('title', trans('menus.teacherstatement_management') . ' | ' . trans('menus.create_teacherstatement'))

@section('page-header')
    <h1>
        {{ trans('menus.teacherstatement_management') }}
        <small>{{ trans('menus.create_teacherstatement') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li>{!! link_to_route('admin.teacherstatements.index', trans('menus.teacherstatements')) !!}</li>
    <li class="active">{!! link_to_route('admin.teacherstatements.create', trans('menus.create_teacherstatement')) !!}</li>
@stop

@section('content')

    {!! Form::open(['route' => 'admin.teacherstatements.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post']) !!}

    
    <div class="form-group">
        {!! Form::label('teacher', trans('strings.workshop'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('teacher', ([] ), ['id' => 'question', 'disabled' => 'disabled', 'class' => 'form-control', 'rows' => 5] ) !!}
        </div>
    </div><!--form control-->
    
    <div class="form-group">
        {!! Form::label('date', trans('strings.date'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('date', null, ['class' => 'form-control datemask', 'placeholder' => trans('strings.date')]) !!}
        </div>
    </div><!--form control-->
    <div class="form-group">
        {!! Form::label('product_name', trans('validation.attributes.description'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('product_name', null, ['class' => 'form-control', 'placeholder' => trans('strings.description')]) !!}
        </div>
    </div><!--form control-->
    <div class="form-group">
        {!! Form::label('value', trans('validation.attributes.value'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('value', null, ['class' => 'form-control money', 'placeholder' => trans('strings.value')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        <label class="col-lg-2 control-label">{{ trans('strings.anticipation') }}</label>
        <div class="col-lg-1">
            <div class="sw-green create-permissions-switch">
                <div class="onoffswitch">
                    <input type="checkbox" value="1" name="anticipation" class="toggleBtn onoffswitch-checkbox" id="anticipation" >
                    <label for="anticipation" class="onoffswitch-label">
                        <div class="onoffswitch-inner"></div>
                        <div class="onoffswitch-switch"></div>
                    </label>
                </div>
            </div><!--green checkbox-->
        </div>
    </div><!--form control-->

        <div class="pull-left">
            <a href="{{route('admin.teacherstatements.index')}}" class="btn btn-danger">{{ trans('strings.cancel_button') }}</a>
        </div>

        <div class="pull-right">
            <input type="submit" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
        </div>
        <div class="clearfix"></div>

    {!! Form::close() !!}
@stop