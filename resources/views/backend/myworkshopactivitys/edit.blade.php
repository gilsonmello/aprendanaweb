
@extends ('backend.layouts.master')

@section ('title', trans('menus.workshopactivity_management') . ' | ' . trans('menus.edit_workshopactivity'))

@section('page-header')
    <h1>
        {{ trans('menus.workshopactivitys') }}
        <small>{{ trans('menus.edit_workshopactivity') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li>{!! link_to_route('admin.workshopactivitys.index', trans('menus.workshopactivitys')) !!}</li>
    <li class="active">{!! link_to_route('admin.workshopactivitys.create', trans('menus.edit_workshopactivity')) !!}</li>
@stop

@section('content')

    <div id="course-data" data-course-id="{{ $workshopactivity->workshop->course_id }}"></div>


    {!! Form::model($workshopactivity, ['route' => ['admin.workshopactivitys.update', $workshopactivity->id], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH', 'files' => true]) !!}

    <div class="form-group">
        {!! Form::label('description', trans('strings.description'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('description', null, ['class' => 'form-control', 'placeholder' => trans('strings.description')]) !!}
        </div>

    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('image', trans('crud.workshopactivitys.url_document'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            <input type="file" name="url_document"/>
            @if(isset($workshopactivity->url_document) && !empty($workshopactivity->url_document))
               <a style="margin-top: 5px;" type="button" target="_blank" href="{{ $workshopactivity->url_document }}" class="btn btn-success" ></i>&nbsp;FOLHA DE RESPOSTA</a>
            @endif
        </div><!-- /.col -->
    </div>


    <div class="form-group">
        {!! Form::label('image', trans('crud.workshopactivitys.url_response'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            <input type="file" name="url_response"/>
            @if(isset($workshopactivity->url_response) && !empty($workshopactivity->url_response))
               <a style="margin-top: 5px;" type="button" target="_blank" href="{{ $workshopactivity->url_response }}" class="btn btn-success" ></i>&nbsp;ESPELHO DE RESPOSTA</a>
            @endif
        </div><!-- /.col -->
    </div>

    <div class="form-group">
        {!! Form::label('text', trans('strings.question_text'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::textarea('text', null, ['class' => 'form-control textarea', 'placeholder' => trans('strings.question_text')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('text_response', trans('crud.workshopactivitys.text_response'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::textarea('text_response', null, ['class' => 'form-control textarea', 'placeholder' => trans('crud.workshopactivitys.text_response')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('minimum_grade', trans('strings.minimum_grade'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('minimum_grade', str_replace('.',',',$workshopactivity->minimum_grade), ['class' => 'form-control', 'placeholder' => trans('strings.minimum_grade')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('available_days_after_workshop', trans('strings.available_days_after_workshop'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('available_days_after_workshop', null, ['class' => 'form-control', 'placeholder' => trans('strings.available_days_after_workshop')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('available_date', trans('strings.available_date'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('available_date', null, ['class' => 'form-control datepicker datemask', 'placeholder' => trans('strings.available_date')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('submit_deadline_days', trans('strings.submit_deadline_days'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('submit_deadline_days', null, ['class' => 'form-control', 'placeholder' => trans('strings.submit_deadline_days')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('submit_deadline_date', trans('strings.submit_deadline_date'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('submit_deadline_date', null, ['class' => 'form-control datepicker datemask', 'placeholder' => trans('strings.submit_deadline_date')]) !!}
        </div>
    </div><!--form control-->


    <div class="form-group">
        {!! Form::label('evaluation_deadline_days', trans('strings.evaluation_deadline_days'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('evaluation_deadline_days', null, ['class' => 'form-control', 'placeholder' => trans('strings.evaluation_deadline_days')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('evaluation_deadline_date', trans('strings.evaluation_deadline_date'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('evaluation_deadline_date', null, ['class' => 'form-control datepicker datemask', 'placeholder' => trans('strings.evaluation_deadline_date')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('explanation_url', trans('strings.explanation_url'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('explanation_url', null, ['class' => 'form-control', 'placeholder' => trans('strings.explanation_url')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('estimated_duration', trans('strings.estimated_duration'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('estimated_duration', null, ['class' => 'form-control', 'placeholder' => trans('strings.estimated_duration')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        <label class="col-lg-2 control-label">{{ trans('strings.personal_evaluation') }}</label>
        <div class="col-lg-1">
            <div class="sw-green create-permissions-switch">
                <div class="onoffswitch">
                    <input type="checkbox" value="1" name="personal_evaluation" class="toggleBtn onoffswitch-checkbox" id="course-personal_evaluation" @if($workshopactivity->personal_evaluation == 1)checked="checked"@endif>
                    <label for="course-personal_evaluation" class="onoffswitch-label">
                        <div class="onoffswitch-inner"></div>
                        <div class="onoffswitch-switch"></div>
                    </label>
                </div>
            </div><!--green checkbox-->
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('lessons', trans('validation.attributes.lessons'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::select('lessons[]', $workshopactivity->lessons->lists('readable_name','id')->all(), $workshopactivity->lessons->lists('readable_name','id')->all(), ['class' => 'form-control lessons-select', 'multiple' => 'multiple']) !!}
        </div><!-- /.col -->
    </div>



    <div class="pull-left">
            <a href="{{route('admin.workshopactivitys.index', ['page' => Session::get('lastpage', '1')])}}" class="btn btn-danger">{{ trans('strings.cancel_button') }}</a>
        </div>

        <div class="pull-right">
            <input type="submit" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
        </div>
        <div class="clearfix"></div>

    {!! Form::close() !!}
@stop
