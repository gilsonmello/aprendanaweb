
@extends ('backend.layouts.master')

@section ('title', trans('menus.analysis_management') . ' | ' . trans('menus.edit_analysis'))

@section('page-header')
    <h1>
        {{ trans('menus.analysis') }}
        <small>{{ trans('menus.edit_analysis') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li>{!! link_to_route('admin.analysiss.index', trans('menus.analysis')) !!}</li>
    <li class="active">{!! link_to_route('admin.analysiss.create', trans('menus.edit_analysis')) !!}</li>
@stop

@section('content')

    {!! Form::model($analysis, ['route' => ['admin.analysiss.update', $analysis->id], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH']) !!}

        <div class="form-group">
            {!! Form::label('nome', trans('validation.attributes.title'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('title', $analysis->title, ['class' => 'form-control', 'placeholder' => trans('strings.title')]) !!}
            </div>
        </div><!--form control-->
    <div class="form-group">
        {!! Form::label('subjects', trans('strings.discipline'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! ($analysis->subject != null ? $analysis->subject->name : "") !!}

        </div>
    </div>

    <div class="form-group">
        {!! Form::label('analysisexamgroups', trans('validation.attributes.analysisexamgroups'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! ($analysis->analysisExamGroup != null ? $analysis->analysisExamGroup->title : "" ) !!}

        </div>
    </div>

    <div class="form-group">
        {!! Form::label('intro_page', trans('crud.analysis.intro_page'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('intro_page', null, ['class' => 'form-control', 'placeholder' => trans('crud.analysis.intro_page')]) !!}
        </div>

    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('intro_text', trans('crud.analysis.intro_text'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::textarea('intro_text', null, ['class' => 'form-control textarea', 'placeholder' => trans('crud.analysis.intro_text')]) !!}
        </div>

    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('conclusion_text', trans('crud.analysis.conclusion_text'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::textarea('conclusion_text', null, ['class' => 'form-control textarea', 'placeholder' => trans('crud.analysis.conclusion_text')]) !!}
        </div>

    </div><!--form control-->


    <div class="pull-left">
            <a href="{{route('admin.analysiss.index', ['page' => Session::get('lastpage', '1')])}}" class="btn btn-danger">{{ trans('strings.cancel_button') }}</a>
        </div>

        <div class="pull-right">
            <input type="submit" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
        </div>
        <div class="clearfix"></div>

    {!! Form::close() !!}
@stop