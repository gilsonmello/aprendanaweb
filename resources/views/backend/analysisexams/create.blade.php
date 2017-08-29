@extends ('backend.layouts.master')

@section ('title', trans('menus.analysisexam_management') . ' | ' . trans('menus.create_analysisexam'))

@section('page-header')
    <h1>
        {{ trans('menus.analysisexam_management') }}
        <small>{{ trans('menus.create_analysisexam') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li>{!! link_to_route('admin.analysisexams.index', trans('menus.analysisexams')) !!}</li>
    <li class="active">{!! link_to_route('admin.analysisexams.create', trans('menus.create_analysisexam')) !!}</li>
@stop

@section('content')

    {!! Form::open(['route' => 'admin.analysisexams.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post']) !!}

        <div class="form-group">
            {!! Form::label('title', trans('validation.attributes.title'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => trans('strings.title')]) !!}
            </div>

        </div><!--form control-->

    <div class="form-group">
        {!! Form::label('acronym', trans('strings.acronym'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('acronym', null, ['class' => 'form-control', 'placeholder' => trans('strings.acronym')]) !!}
        </div>

    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('date', trans('strings.date_realization'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('date', null, ['class' => 'form-control datemask datepicker', 'placeholder' => trans('strings.date_realization')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('date_result', trans('strings.date_result'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('date_result', null, ['class' => 'form-control datemask datepicker', 'placeholder' => trans('strings.date_result')]) !!}
        </div>
    </div><!--form control-->



    <div class="form-group">
        {!! Form::label('sources', trans('strings.discipline'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-6">
            {!! Form::select("sources[]",  [''=>''] + $sources->lists("name","id")->all(), null, ['class' => 'form-control select2' ])  !!}

        </div>
    </div>

    <div class="form-group">
        {!! Form::label('institutions', trans('strings.institution'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-6">
            {!! Form::select("institutions[]",  [''=>''] + $institutions->lists("name","id")->all(), null, ['class' => 'form-control select2' ])  !!}

        </div>
    </div>

    <div class="form-group">
        {!! Form::label('offices', trans('strings.office'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-6">
            {!! Form::select("offices[]",  [''=>''] + $offices->lists("name","id")->all(), null, ['class' => 'form-control select2' ])  !!}

        </div>
    </div>

    <div class="form-group">
        <label class="col-lg-2 control-label">{{ trans('validation.attributes.active') }}</label>
        <div class="col-lg-1">
            <div class="sw-green create-permissions-switch">
                <div class="onoffswitch">
                    <input type="checkbox" value="1" name="is_active" class="toggleBtn onoffswitch-checkbox" id="analysisexam-active" checked="checked">
                    <label for="analysisexam-active" class="onoffswitch-label">
                        <div class="onoffswitch-inner"></div>
                        <div class="onoffswitch-switch"></div>
                    </label>
                </div>
            </div><!--green checkbox-->
        </div>
    </div><!--form control-->


    <div class="pull-left">
            <a href="{{route('admin.analysisexams.index')}}" class="btn btn-danger">{{ trans('strings.cancel_button') }}</a>
        </div>

        <div class="pull-right">
            <input type="submit" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
        </div>
        <div class="clearfix"></div>




    <div class="clearfix"></div>

    {!! Form::close() !!}
@stop