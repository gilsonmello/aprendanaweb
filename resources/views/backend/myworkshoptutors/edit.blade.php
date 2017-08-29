
@extends ('backend.layouts.master')

@section ('title', trans('menus.edit_myworkshoptutors'))

@section('page-header')
    <h1>
        {{ trans('menus.edit_myworkshoptutors') }}
        <small>{{ trans('menus.edit_myworkshoptutors') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li>{!! link_to_route('admin.myworkshoptutors.tutorsthestudents', trans('menus.myworkshoptutors')) !!}</li>
    <li class="active">{!! trans('menus.edit_myworkshoptutors') !!}</li>
@stop

@section('content')

    {!! Form::model($myworkshoptutor, ['route' => ['admin.myworkshoptutors.update', $myworkshoptutor->id], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH']) !!}

        <br>
        <div class="form-group">
            {!! Form::label('s', trans('strings.student'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text(null, $myworkshoptutor->enrollment->student->name, ['readonly', 'class' => 'form-control', 'placeholder' => trans('strings.student')]) !!}
            </div>
        </div><!--form control-->

        <div class="form-group">
            {!! Form::label('course_id', trans('strings.course'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text(null, $myworkshoptutor->workshop->course->title, ['readonly', 'class' => 'form-control', 'placeholder' => trans('strings.course')]) !!}
            </div>
        </div><!--form control-->

        <div class="form-group">
            {!! Form::label('workshop', trans('strings.workshop'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text(null, $myworkshoptutor->workshop->description, ['readonly', 'class' => 'form-control', 'placeholder' => trans('strings.workshop')]) !!}
            </div>
        </div><!--form control-->
        <div class="form-group">
            {!! Form::label('criteria', trans('strings.criteria'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text(null, $myworkshoptutor->criteria->description, ['readonly', 'class' => 'form-control', 'placeholder' => trans('strings.criteria')]) !!}
            </div>
        </div><!--form control-->
        <div class="form-group">
            {!! Form::label('tutor' , trans('strings.tutor'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="form-input col-md-4">
                {!! Form::select('tutor_id', $tutors->lists('name', 'id')->all(), $myworkshoptutor->tutor->id, ['class' => 'form-control select2', 'placeholder' => trans('strings.tutor') ])  !!}
            </div>
        </div>

        @if($myworkshoptutor->activity != null)
            <div class="form-group">
                {!! Form::label('description', trans('strings.activity'), ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::textarea(null, $myworkshoptutor->activity->description, ['readonly','class' => 'form-control', 'placeholder' => trans('strings.description')]) !!}
                </div>
            </div><!--form control-->
        @endif
        <div class="form-group">

            {!! Form::label('description', '&nbsp;', ['class' => 'col-lg-2 control-label']) !!}
            <div class="pull-left" style="margin-left: 1.3%;">
                <a href="{{route('admin.myworkshoptutors.index', ['page' => Session::get('lastpage', '1')])}}" class="btn btn-danger">{{ trans('strings.cancel_button') }}</a>
            </div>

            <div class="pull-right" style="margin-right: 1.3%;">
                <input type="submit" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
            </div>
        </div>

        
        <div class="clearfix"></div>

    {!! Form::close() !!}
@stop