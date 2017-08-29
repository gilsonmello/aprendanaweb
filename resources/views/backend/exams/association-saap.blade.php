@extends ('backend.layouts.master')

@section ('name', trans('menus.exams'))



@section('page-header')
    <h1>
        {{ trans('menus.exams') }}
        <small>{{ trans('menus.all_exams') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.exams.index', trans('menus.exams')) !!}</li>
@stop

@section('content')
    
    <div class="box box-primary">
        <br>
        <div class="row" style="padding: 10px;">
            <div class="form-group">
                <div class="col-md-2">
                    {!! Form::label('f_StudentReportController_date_begin', "Título do SAAP") !!}
                    
                </div>
                <div class="col-lg-7">
                        {!! Form::text('title', "SAAP TESTE", ['disabled' => 'disabled', 'class' => 'form-control title-has-slug', 'placeholder' => trans('strings.title')]) !!}
                    </div>
            </div>
        </div>
        <div class="box-header with-border">
            <h3 class="box-title">Filtro</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                </button>
            </div>
        </div>

        {!! Form::open(array('route' => array('admin.questions.reports'), 'method' => 'post'))  !!}
            <div class="box-body">
                <br>
                </hr>
                <div class="row">
                    {!! Form::hidden('f_submit', '1'  ) !!}
                    <div class="form-group">
                        <div class="col-md-1">
                            {!! Form::label('f_QuestionController_year',  trans('strings.year')) !!}
                        </div>
                        <div class="col-md-1">
                            <select class="select2">
                                <option>2010</option>
                                <option>2011</option>
                                <option>2012</option>
                                <option>2013</option>
                            </select>
                        {{-- {!! Form::select('f_QuestionController_discipline_id', ['' => ''] + $disciplines->lists('name', 'id')->all(), $questioncontrollerothemeid, ['class' => 'select2']) !!} --}}
                        </div>
                        <div class="col-md-1" style="padding-left: 120px; width: 20%;">
                            {!! Form::label('f_QuestionController_year', "Banca" ) !!}
                        </div>
                        <div class="col-md-2">
                            <select class="select2">
                                <option>FGV</option>
                                <option>CESGRANRIO</option>
                            </select>
                        {{-- {!! Form::select('f_QuestionController_discipline_id', ['' => ''] + $disciplines->lists('name', 'id')->all(), $questioncontrollerothemeid, ['class' => 'select2']) !!} --}}
                        </div>
                    </div>
                </div>
                <br><br>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-1">
                            {!! Form::label('f_QuestionController_year', "Cargo" ) !!}
                        </div>
                        <div class="col-md-2">
                            <select class="select2">
                                <option>Cargo 01</option>
                                <option>Cargo 02</option>
                            </select>
                        {{-- {!! Form::select('f_QuestionController_discipline_id', ['' => ''] + $disciplines->lists('name', 'id')->all(), $questioncontrollerothemeid, ['class' => 'select2']) !!} --}}
                        </div>
                        <div class="col-md-1" style="padding-left: 60px; width: 12%;">
                            {!! Form::label('f_QuestionController_year', "Professor" ) !!}
                        </div>
                        <div class="col-md-2">
                            <select class="select2">
                                <option>Salomão Viana</option>
                                <option>Dirley da Cunha</option>
                            </select>
                        {{-- {!! Form::select('f_QuestionController_discipline_id', ['' => ''] + $disciplines->lists('name', 'id')->all(), $questioncontrollerothemeid, ['class' => 'select2']) !!} --}}
                        </div>
                    </div>
                </div>
                <br><br>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-1">
                            {!! Form::label('f_QuestionController_year', "Ambito" ) !!}
                        </div>
                        <div class="col-md-2">
                            <select class="select2">
                                <option>Ambito 01</option>
                                <option>Ambito 02</option>
                            </select>
                        {{-- {!! Form::select('f_QuestionController_discipline_id', ['' => ''] + $disciplines->lists('name', 'id')->all(), $questioncontrollerothemeid, ['class' => 'select2']) !!} --}}
                        </div>
                    </div>
                </div>
                <br>
            </div>
        {!! Form::close() !!}
    </div>

    <br><br>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-1">
                            {!! Form::label('f_QuestionController_year', "Curso" ) !!}
                        </div>
                        <div class="col-md-3">
                            <select class="select2" multiple="multiple">
                                <option>Novo CPC</option>
                                <option>Direito Constitucional</option>
                            </select>
                        {{-- {!! Form::select('f_QuestionController_discipline_id', ['' => ''] + $disciplines->lists('name', 'id')->all(), $questioncontrollerothemeid, ['class' => 'select2']) !!} --}}
                        </div>
                        <div class="col-md-1">
                            {!! Form::label('f_QuestionController_year', "Disciplina" ) !!}
                        </div>
                        <div class="col-md-3">
                            <select class="select2" multiple="multiple">
                                <option>Disciplina 01</option>
                                <option>Disciplina 02</option>
                            </select>
                        {{-- {!! Form::select('f_QuestionController_discipline_id', ['' => ''] + $disciplines->lists('name', 'id')->all(), $questioncontrollerothemeid, ['class' => 'select2']) !!} --}}
                        </div>
                        <div class="col-md-1">
                            {!! Form::label('f_QuestionController_year', "Tema" ) !!}
                        </div>
                        <div class="col-md-3">
                            <select class="select2" multiple="multiple">
                                <option>Tema 01</option>
                                <option>Tema 02</option>
                            </select>
                        {{-- {!! Form::select('f_QuestionController_discipline_id', ['' => ''] + $disciplines->lists('name', 'id')->all(), $questioncontrollerothemeid, ['class' => 'select2']) !!} --}}
                        </div>
                    </div>
                </div>
    
@stop