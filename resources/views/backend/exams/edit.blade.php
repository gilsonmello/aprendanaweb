@extends ('backend.layouts.master')

@section ('title', trans('menus.exam_management') . ' | ' . trans('menus.create_exam'))

@section ('before-styles-end')
    {!! HTML::style('css/plugin/jquery.onoff.css') !!}
@stop

@section('page-header')
    <h1>
        {{ trans('menus.exam_management') }}
        <small>{{ trans('menus.create_exam') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li>{!! link_to_route('admin.exams.index', trans('menus.exams')) !!}</li>
    <li class="active">{!! link_to_route('admin.exams.create', trans('menus.create_exam')) !!}</li>
@stop

@section('content')

    <div class="pull-right" style="margin-bottom:10px">
        <a href="{{route('admin.groups.index')}}?f_exam_id={{$exam->id}}" class="btn btn-primary btn-xs">{{ trans('menus.exam_groups') }}</a>
    </div>
    <br/>
    <br/>

    {!! Form::model($exam, ['route' => ['admin.exams.update', $exam->id], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH', 'files' => true]) !!}

        <div class="form-group">
            {!! Form::label('subsection_id', trans('strings.section'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::select('subsection_id', $subsections, null, ['class' => 'form-control']) !!}
            </div><!-- /.col -->
        </div>

        <div class="form-group">
            {!! Form::label('title', trans('strings.title'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('title', null, ['class' => 'form-control title-has-slug', 'placeholder' => trans('strings.title')]) !!}
            </div>
        </div><!--form control-->

        <div class="form-group">
            {!! Form::label('slug', trans('strings.slug'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('slug', null, ['class' => 'form-control slug-from-title', 'placeholder' => trans('strings.slug')]) !!}
            </div>
        </div><!--form control-->

        <div class="form-group">
            {!! Form::label('description', trans('strings.description'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                <div class="box-body" style="padding: 0px;">
                    {!! Form::textarea('description', null, ['class' => 'form-control textarea', 'placeholder' => trans('strings.description')]) !!}
                </div>
            </div>
        </div><!--form control-->

    <div class="form-group">
        {!! Form::label('explanation', trans('strings.explanation'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            <div class="box-body" style="padding: 0px;">
                {!! Form::textarea('explanation', null, ['class' => 'form-control textarea', 'placeholder' => trans('strings.explanation')]) !!}
            </div>
        </div>
    </div><!--form control-->


    <div class="form-group">
        {!! Form::label('image', trans('strings.classroom_img'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            <input type="file" name="classroom_img"/> <br/>
            <img height="100"  src="{{ imageurl('exams/',$exam->id, $exam->classroom_img, 100, 'generic.png', true) }}">
        </div><!-- /.col -->
    </div>


    <div class="form-group">
            {!! Form::label('video_ad_url', trans('strings.video'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('video_ad_url', null, ['class' => 'form-control', 'placeholder' => trans('strings.video')]) !!}
            </div>
        </div><!--form control-->

    <div class="form-group">
        {!! Form::label('analysis', trans('strings.analysis'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('analysis', null, ['class' => 'form-control', 'placeholder' => trans('strings.analysis')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('result_level', trans('strings.result_level'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::radio('result_level', '1', true) !!}  {!! trans('strings.result_level_1') !!}
            &nbsp;&nbsp;{!! Form::radio('result_level', '2') !!} {!! trans('strings.result_level_2') !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('max_tries', trans('strings.max_tries'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('max_tries',  null, ['class' => 'form-control', 'placeholder' => trans('strings.max_tries')]) !!}
        </div>
    </div><!--form control-->


    <div class="form-group">
        {!! Form::label('duration', trans('strings.time_to_execute'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('duration', str_replace('.',',',$exam->duration), ['class' => 'form-control ', 'placeholder' => trans('strings.time_to_execute')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('video_time', trans('strings.total_video_time'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('video_time', str_replace('.',',',$exam->video_time), ['class' => 'form-control', 'placeholder' => trans('strings.total_video_time')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('minimum_percentage', trans('strings.minimum_percentage'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('minimum_percentage', null, ['class' => 'form-control', 'placeholder' => trans('strings.minimum_percentage')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('questions_count', trans('strings.questions_count'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('questions_count', null, ['class' => 'form-control', 'placeholder' => trans('strings.questions_count')]) !!}
        </div>
    </div><!--form control-->


    <div class="form-group">
            {!! Form::label('tags', 'Tags', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::select('tags[]', $exam->tags_array, $exam->tags_array, ['class' => 'form-control tags-select', 'multiple' => 'multiple']) !!}
            </div>
        </div>


    <div class="form-group">
        {!! Form::label('teacher_message_id', trans('strings.teacher_message_id'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::select('teacher_message_id', $teachers->lists("name","id"), null, ['class' => 'form-control']) !!}
        </div><!-- /.col -->
    </div>


    <div class="form-group">
        {!! Form::label('required_reading', trans('strings.required_reading'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            <div class="box-body" style="padding: 0px;">
                {!! Form::textarea('required_reading', null, ['class' => 'form-control textarea', 'placeholder' => trans('strings.required_reading')]) !!}
            </div>
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('additional_reading', trans('strings.additional_reading'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            <div class="box-body" style="padding: 0px;">
                {!! Form::textarea('additional_reading', null, ['class' => 'form-control textarea', 'placeholder' => trans('strings.additional_reading')]) !!}
            </div>
        </div>
    </div><!--form control-->

    {{--<div class="form-group">--}}
        {{--{!! Form::label('finish_message', trans('strings.finish_message'), ['class' => 'col-lg-2 control-label']) !!}--}}
        {{--<div class="col-lg-10">--}}
            {{--<div class="box-body" style="padding: 0px;">--}}
                {{--{!! Form::textarea('finish_message', null, ['class' => 'form-control textarea', 'placeholder' => trans('strings.finish_message')]) !!}--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div><!--form control-->--}}


    <div class="pull-left">
        <a href="{{route('admin.exams.index')}}" class="btn btn-danger">{{ trans('strings.cancel_button') }}</a>
    </div>


    <div class="pull-right">
            <input type="submit" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
        </div>
        <div class="clearfix"></div>

    {!! Form::close() !!}
@stop