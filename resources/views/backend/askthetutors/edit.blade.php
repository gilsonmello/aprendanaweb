@extends ('backend.layouts.master')

@section ('title', trans('menus.user_management') . ' | ' . trans('menus.create_user'))

@section('page-header')
    <h1>
        {{ trans('menus.asktheteachers') }}
        <small>{{ trans('menus.edit_asktheteacher') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li>{!! link_to_route('admin.askthetutors.index', trans('menus.asktheteachers')) !!}</li>
    <li class="active">{!! trans('menus.edit_asktheteacher') !!}</li>
@stop

@section('content')

    {!! Form::model($asktheteacher, ['route' => ['admin.askthetutors.updateAskTheTutor', $asktheteacher->id], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'POST', 'files' => true]) !!}

    <div class="form-group">
        {!! Form::label('question', trans('strings.question'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::textarea('question', null, ['id' => 'question', 'disabled' => 'disabled', 'class' => 'form-control', 'rows' => 5] ) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('student', trans('strings.student'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('student', ( $asktheteacher->userStudent != null ? $asktheteacher->userStudent->name : ""), ['id' => 'question', 'disabled' => 'disabled', 'class' => 'form-control', 'rows' => 5] ) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('teacher', trans('strings.workshop'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('teacher', ( $asktheteacher->workshop != null ? $asktheteacher->workshop->description : ""), ['id' => 'question', 'disabled' => 'disabled', 'class' => 'form-control', 'rows' => 5] ) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('teacher', trans('strings.tutor'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('teacher', ( $asktheteacher->userTeacher != null ? $asktheteacher->userTeacher->name : ""), ['id' => 'question', 'disabled' => 'disabled', 'class' => 'form-control', 'rows' => 5] ) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('date', trans('strings.date'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('date_question',  format_datetimebr($asktheteacher->date_question), ['id' => 'question', 'disabled' => 'disabled', 'class' => 'form-control', 'rows' => 5] ) !!}
        </div>
    </div><!--form control-->

        <div class="form-group">
            {!! Form::label('answer', trans('validation.attributes.answer'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::textarea('answer', null, ['id' => 'answer', 'class' => 'form-control', 'rows' => 5] ) !!}
            </div>
        </div><!--form control-->

        <div class="pull-left">
            <a href="{{route('admin.asktheteachers.index', ['page' => Session::get('lastpage', '1')])}}" class="btn btn-danger">{{ trans('strings.cancel_button') }}</a>
        </div>

        <div class="pull-right">
            <input type="submit" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
        </div>
        <div class="clearfix"></div>

    {!! Form::close() !!}
@stop