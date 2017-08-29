@extends ('backend.layouts.master')

@section ('question', trans('menus.asktheteachers'))



@section('page-header')
    <h1>
        {{ trans('menus.asktheteachers') }}
        <small>{{ trans('menus.all_asktheteachers') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
@stop

@section('content')

    <div class="pull-right" style="margin-bottom:10px">
    </div>

    <div class="clearfix"></div>

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-question">Filtro</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        {!! Form::open(array('route' => array('admin.askthetutors.index'), 'class' => 'form-horizontal', 'method' => 'get'))  !!}
        <div class="box-body">
            <div class="row">
                {!! Form::hidden('f_submit', '1'  ) !!}
                {!! Form::label('f_AskTheTutorController_question',  trans('strings.question'), ['class' => 'col-md-2 control-label']) !!}
                <div class="col-md-8">
                    {!! Form::text('f_AskTheTutorController_question', $asktheteachercontrollerquestion, ['class' => 'form-control']  ) !!}
                </div>
                <div class="col-md-2 no-padding" style="margin-top:5px;">
                    <label>{!! Form::radio('f_AskTheTutorController_is_replied', '2',($asktheteachercontrollerisreplied ===  '2' ? true : false)) !!} {!!trans('strings.all_male')!!} </label> &nbsp;
                    <label>{!! Form::radio('f_AskTheTutorController_is_replied', '1',($asktheteachercontrollerisreplied ===  '1' ? true : false)) !!} {!!trans('strings.yes')!!} </label> &nbsp;
                    <label>{!! Form::radio('f_AskTheTutorController_is_replied', '0',($asktheteachercontrollerisreplied ===  '0' ? true : false)) !!} {!!trans('strings.no')!!}</label>
                </div>
                
            </div>
        </div>
        <div class="box-footer">
            {!! Form::submit( trans('strings.search'), ['class' => 'btn btn-primary btn-xs']) !!}
        </div>
        {!! Form::close() !!}
    </div>

    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>{{ trans('crud.asktheteachers.question') }}</th>
            <th>{{ trans('strings.workshop') }}</th>
            <th width="20%">{{ trans('strings.tutor') }}</th>
            <th width="12%">{{ trans('crud.asktheteachers.date') }}</th>
            <th width="8%">{{ trans('crud.asktheteachers.replyed') }}</th>
            <th width="8%">{{ trans('crud.actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($asktheteachers as $asktheteacher)
            <tr>
                <td>{!! $asktheteacher->question !!}</td>
                <td>{!! ( $asktheteacher->workshop != null) ? $asktheteacher->workshop->description : "" !!}</td>
                <td>{!! ( $asktheteacher->userTeacher != null ? $asktheteacher->userTeacher->name : "") !!}</td>
                <td>{!! format_datetimebr($asktheteacher->date_question) !!}</td>
                <td>{!! $asktheteacher->is_replied_label !!}</td>
                <td>{!! $asktheteacher->action_buttons_ask_the_tutor !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="pull-left">
        {!! count($asktheteachers->total()) > 0  ? $asktheteachers->total()." ". trans('crud.asktheteachers.total') : "Não existem dúvidas postadas ou o seu perfil não é um tutor ou coordenador." !!}
    </div>

    <div class="pull-right">
        {!! $asktheteachers->render() !!}
    </div>

    <div class="clearfix"></div>
@stop