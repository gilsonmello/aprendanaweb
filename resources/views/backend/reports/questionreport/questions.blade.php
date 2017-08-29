@extends ('backend.layouts.master')

@section ('title', trans('menus.student_performance'))

@section('page-header')
    <h1>
        {{ trans('menus.student_performance') }}
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.studentreports.index', trans('menus.student_performance')) !!}</li>
@stop

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Filtro</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        {!! Form::open(array('route' => array('admin.questions.reports'), 'method' => 'get'))  !!}
            <div class="box-body">
                <div class="row">
                    {!! Form::hidden('f_submit', '1'  ) !!}
                    <div class="form-group">
                        {!! Form::label('answer_type', trans('strings.answer_type'), ['class' => 'col-lg-2 control-label']) !!}
                        <div class="col-lg-4">
                            {!! Form::radio('f_QuestionController_original', '0', $questioncontrolleroriginal == '0' ? true : false) !!}  {!! trans('strings.adaptada') !!}<br>
                            {!! Form::radio('f_QuestionController_original', '1', $questioncontrolleroriginal == '1' ? true : false) !!}  {!! trans('strings.original_question') !!}<br>
                            {!! Form::radio('f_QuestionController_original', '2', $questioncontrolleroriginal == '2' ? true : false) !!}  {!! trans('strings.concursos_anteriores') !!}
                        </div>
                        <div class="col-md-1">
                            {!! Form::label('f_QuestionController_year',  trans('strings.year')) !!}&nbsp;&nbsp;&nbsp;&nbsp;
                        </div>
                        <div class="col-md-2">
                            {!! Form::text('f_QuestionController_year', $questioncontrolleryear, ['class' => '']) !!}&nbsp;&nbsp;&nbsp;&nbsp;
                        </div>
                    </div>
                </div>
                <hr/>
                <div class="row">
                    <div class="col-md-1">
                        {!! Form::label('f_QuestionController_discipline_id', trans('strings.module')) !!}
                    </div>
                    <div class="col-md-7">
                        {!! Form::select('f_QuestionController_discipline_id', ['' => ''] + $disciplines->lists('name', 'id')->all(), $questioncontrollerothemeid, ['class' => 'select2']) !!}
                    </div>
                </div>
                <hr/>
                <div class="row">
                    <div class="col-md-1">
                        {!! Form::label('f_QuestionController_teacher_id', trans('strings.teacher')) !!}
                    </div>
                    <div class="col-md-7">
                        {!! Form::select('f_QuestionController_teacher_id', ['' => ''] + $teachers->lists('name', 'id')->all(), $questioncontrollerteacherid, ['class' => 'select2']) !!}
                    </div>
                </div>
                <hr/>
                <div class="row">
                    <div class="col-md-1">
                        {!! Form::label('f_QuestionController_teacher_id', trans('strings.source')) !!}
                    </div>
                    <div class="col-md-7">
                        {!! Form::select('f_QuestionController_source_id', ['' => ''] + $sources->lists('name', 'id')->all(), $questioncontrollersourceid, ['class' => 'select2']) !!}
                    </div>
                </div>

                <hr/>
                <div class="row">
                    <div class="col-md-2">
                        {!! Form::label('duplicated_questions', trans('strings.duplicated_questions')) !!}
                    </div>
                    <div class="col-md-1">
                        {!!  Form::checkbox('duplicated_questions', '1', $questioncontrollerduplicated == '1' ? 'checked' : '')  !!}
                    </div>
                    <div class="col-md-3" style="padding-right: 0">
                        {!! Form::label('export_to_csv', trans('strings.export_to_csv')) !!}
                    </div>
                    <div class="col-md-1" style="padding-left: 0">
                        {!!  Form::checkbox('export_to_csv', '1', $questioncontrollerexporttocsv == '1' ? 'checked' : '')  !!}
                    </div>
                </div>
                <hr/>

                <div >
                    {!! Form::submit( trans('strings.search'), ['class' => 'btn btn-primary btn-xs']) !!}
                </div>
            </div>
        {!! Form::close() !!}
    </div>
    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>{{trans('strings.answer_type')}}</th>
            <th width="">{{ trans('strings.question_text') }}</th>
            <th width="">{{ trans('strings.source') }}</th>
            <th width="">{{ trans('strings.year') }}</th>
            <th width="">{{ trans('strings.result_level_1')}}</th>
            <th width="">{{ trans('strings.subtheme') }}</th>
            <th width="">{{ trans('strings.teacher') }}</th>
            <th width="2%">{{ trans('strings.count_right') }}</th>
        </tr>
        </thead>
        <tbody>
            @foreach ($results as $result)
                <tr>
                    <td>
                        @if($result->original == 0)
                            {!! trans('strings.adaptada') !!}
                        @elseif($result->original == 1)
                            {!! trans('strings.original_question') !!}
                        @elseif($result->original == 2)
                            Concursos Anteriores
                        @endif
                    </td>
                    <td>{{ $result->text != null ? strip_tags(str_limit($result->text, 200)) : "" }}</td>
                    <td>{{ $result->source_name != null ? $result->source_name : "" }}</td>
                    <td>{{ $result->year != null ? str_limit($result->year, [70]) : "" }}</td>
                    <td>{{ ($result->Theme_name != null && $result->Discipline_name ) ? $result->Discipline_name.' - '.$result->Theme_name : "" }}</td>
                    <td>{{ $result->Subject_name != null ? $result->Subject_name : "" }}</td>
                    <td>{{ $result->Teacher_name != null ? $result->Teacher_name : "" }}</td>
                    <td>{{ ($result->count_exec !=0 ) ? $result->count_right.' ['.number_format($result->count_right / $result->count_exec * 100, 2).'%]' : "[0%]"}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <br/>
    <b>{{ trans('strings.quantity_questions') }}:</b> {!! $results->count()!!}
    <div class="clearfix"></div>
@stop