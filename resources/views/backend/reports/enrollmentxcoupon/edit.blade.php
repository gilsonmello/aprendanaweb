
@extends ('backend.layouts.master')

@section ('title', trans('menus.workshop_management') . ' | ' . trans('menus.edit_workshop'))

@section('page-header')
    <h1>
        {{ trans('menus.workshops') }}
        <small>{{ trans('menus.edit_workshop') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li>{!! link_to_route('admin.workshops.index', trans('menus.workshops')) !!}</li>
    <li class="active">{!! link_to_route('admin.workshops.create', trans('menus.edit_workshop')) !!}</li>
@stop

@section('content')
    <div class="pull-right" style="margin-bottom:10px">
        <a href="{{route('admin.workshopcriterias.index')}}?f_workshop_id={{$workshop->id}}" class="btn btn-primary btn-xs">{{ trans('menus.workshop_criterias') }}</a>
        <a href="{{route('admin.workshopactivitys.index')}}?f_workshop_id={{$workshop->id}}" class="btn btn-primary btn-xs">{{ trans('menus.workshop_activities') }}</a>
        @if (count($evaluationgroups) == 0)
        <a href="{{route('admin.workshoptutors.index')}}?f_workshop_id={{$workshop->id}}" class="btn btn-primary btn-xs">{{ trans('menus.workshop_tutors') }}</a>
        @endif

        @if (count($tutors) == 0)
        <a href="{{route('admin.workshopevaluationgroups.index')}}?f_workshop_id={{$workshop->id}}" class="btn btn-primary btn-xs">{{ trans('menus.workshopevaluationgroups') }}</a>
        @endif
    </div>
    <br/>
    <br/>

    {!! Form::model($workshop, ['route' => ['admin.workshops.update', $workshop->id], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH']) !!}

        <div class="form-group">
            {!! Form::label('nome', trans('strings.description'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('description', $workshop->description, ['class' => 'form-control', 'placeholder' => trans('strings.description')]) !!}
            </div>
        </div><!--form control-->
        <div class="form-group">
            {!! Form::label('teachers', trans('strings.cordinators'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::select('teachers[]', $teachers->lists('name', 'id')->all(), $workshop->coordinators->lists('id')->all(), ['class' => 'form-control select2', 'multiple' => 'multiple']) !!}
            </div><!-- /.col -->
        </div>


        <div class="form-group">
            {!! Form::label('course', trans('strings.course'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!!  $workshop->course->title !!}
            </div>

        </div><!--form control-->

        <div class="form-group">
            {!! Form::label('content', trans('strings.content'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                <div class="box-body" style="padding: 0px;">
                    {!! Form::textarea('content', null, ['class' => 'form-control textarea', 'placeholder' => trans('strings.content')]) !!}
                </div>
            </div>
        </div><!--form control-->

        <div class="form-group">
            {!! Form::label('minimum_grade', trans('strings.minimum_grade'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('minimum_grade', str_replace('.',',',$workshop->minimum_grade), ['class' => 'form-control', 'placeholder' => trans('strings.minimum_grade')]) !!}
            </div>
        </div><!--form control-->

        <div class="form-group">
            {!! Form::label('available_days_after_enrollment', trans('strings.available_days_after_enrollment'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('available_days_after_enrollment', null, ['class' => 'form-control', 'placeholder' => trans('strings.available_days_after_enrollment')]) !!}
            </div>
        </div><!--form control-->

        <div class="form-group">
            {!! Form::label('available_date', trans('strings.available_date'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('available_date', null, ['class' => 'form-control datepicker datemask', 'placeholder' => trans('strings.available_date')]) !!}
            </div>
        </div><!--form control-->


        <div class="pull-left">
            <a href="{{route('admin.workshops.index', ['page' => Session::get('lastpage', '1')])}}" class="btn btn-danger">{{ trans('strings.cancel_button') }}</a>
        </div>

        <div class="pull-right">
            <input type="submit" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
        </div>
        <div class="clearfix"></div>

    {!! Form::close() !!}
@stop