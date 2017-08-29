@extends ('backend.layouts.master')

@section ('name', trans('menus.myworkshoptutors'))

@section('page-header')
    <h1>
        {{ trans('menus.myworkshoptutors') }}
        <small>{{ trans('menus.all_myworkshoptutors') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! trans('menus.myworkshoptutors') !!}</li>
@stop

@section('content')

    <div class="clearfix"></div>

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-name">Filtro</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        {!! Form::open(array('route' => array('admin.myworkshoptutors.tutorsthestudents'), 'class' => 'form-horizontal', 'method' => 'get'))  !!}
            <div class="box-body">
                <div class="row">
                    {!! Form::hidden('f_submit', '1'  ) !!}
                    
                    {!! Form::label('f_MyWorkshopTutorController_name',  trans('strings.name'), ['class' => 'col-md-2 control-label']) !!}
                    <div class="col-md-5">
                        {!! Form::text('f_MyWorkshopTutorController_name', $myworkshoptutorcontrollername, ['class' => 'form-control']  ) !!}
                    </div>

                    <div class="col-md-2">
                        {!! Form::label('f_MyWorkshopTutorController_has_tutor',  "Possui tutor?", ['class' => 'col-md-10 control-label']) !!}
                    </div>
                    <div class="col-md-2 no-padding" style="margin-top:5px;">
                        <label>{!! Form::radio('f_MyWorkshopTutorController_has_tutor', '1',($hastutor ===  '1' || $hastutor ==  '' ? true : false)) !!} {!!trans('strings.yes')!!} </label> &nbsp;
                        <label>{!! Form::radio('f_MyWorkshopTutorController_has_tutor', '0',($hastutor ===  '0' ? true : false)) !!} {!!trans('strings.no')!!}</label>
                    </div>
                </div>

                <br>

                <div class="row">
                        {!! Form::label('f_MyWorkshopTutorController_workshop',  trans('strings.workshop'), ['class' => 'col-md-2 control-label']) !!}
                    <div class="col-md-8">
                        {!! Form::select('f_MyWorkshopTutorController_workshop', ['' => ''] + $workshops->lists('Title', 'Workshop_id')->all(), $myworkshoptutorcontrollerworkshop, ['class' => 'select2']) !!}
                    </div>
                </div>


            </div>
            <div class="box-footer">
                {!! Form::submit( trans('strings.search'), ['class' => 'btn btn-primary btn-xs']) !!}
            </div>
        {!! Form::close() !!}
    </div>

    @if($hastutor == '1')
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th width="20%">{{ trans('strings.course') }}</th>
                    <th width="20%">{{ trans('strings.workshop') }}</th>
                    <th width="20%">{{trans('strings.student') }}</th>
                    <th width="20%">{{trans('strings.tutor') }}</th>
                    <th width="5%">{{ trans('crud.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($myworkshoptutors as $myworkshoptutor)
                    <tr>
                        <td>{!! $myworkshoptutor->enrollment->course->title !!}</td>
                        <td>{!! findWorkshop($myworkshoptutor->Workshop_id)->description !!}</td>
                        <td>{!! $myworkshoptutor->enrollment->student->name !!}</td>
                        <td>{!! $myworkshoptutor->tutor->name !!}</td>
                        <td>{!! $myworkshoptutor->action_buttons !!}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pull-left">
            {!! $myworkshoptutors->total() !!} {{ trans('crud.myworkshoptutors.total') }}
        </div>
        <div class="pull-right">
            {!! $myworkshoptutors->render() !!}
        </div>
    @else
        <table class="table table-striped table-bordered table-hover myworkshoptutors">
            <thead>
                <tr>
                    <th width="40%">{{ trans('strings.course') }}</th>
                    <th width="30%">{{ trans('strings.workshop') }}</th>
                    <th width="30%">{{trans('strings.student') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($myworkshoptutors as $myworkshoptutor) 
                        <tr style="cursor: pointer;" data-enrollment="{!! $myworkshoptutor->id !!}" data-workshop="{!! $myworkshoptutor->Workshop_id!!}">
                            <td>{!! $myworkshoptutor->course->title !!}</td>
                            <td>{!! findWorkshop($myworkshoptutor->Workshop_id)->description !!}</td>
                            <td>{!! $myworkshoptutor->student->name !!}</td>
                        </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pull-left">
            {!! $myworkshoptutors->count() !!} {{ '&nbsp;'.trans('crud.myworkshoptutors.count') }}
        </div>
        <div class="pull-right">
            {!! $myworkshoptutors->render() !!}
        </div>
    @endif

    <div class="clearfix"></div>

    <div class="modal fade" id="modalAddTutor" tabindex="-1" role="dialog" >
        <div class="modal-dialog" role="document" style="width: 80%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="groupSubjectLabel" style="color: #08C">Associar tutor ao aluno {{-- {{ $lesson->sequence }} --}}</h4>
                    <h4 class="modal-title" id="savedGroupLabel" style="color: #08C; display:none"> Grupo atualizado! </h4>
                </div>

                <div class="modal-body">
                    <form id="group-form" class="form-horizontal">
                        <div id="dynamic-flash">
                        </div>
                        <input type="hidden" value="" name="workshop_id" id="workshop"/>
                        <input type="hidden" value="" name="enrollment_id" id="enrollment"/>
                        
                        <br>
                        <br>
                        <div class="row" style="margin-left: 0; margin-right: 0">
                            <div class="col-md-2" style="margin-left: 20px;">
                                {!! Form::label('name', trans('strings.name')) !!}
                            </div>
                            <div class="col-md-7">
                                {!! Form::text('name', null, ['id' => 'name-user', 'readonly' ,'class' => 'form-control', 'placeholder' => trans('strings.name')]) !!}
                            </div>
                        </div>

                        <br>
                        <br>
                        <div class="row" style="margin-left: 0; margin-right: 0">
                            <div class="col-md-2" style="margin-left: 20px;">
                                {!! Form::label('workshop_name', trans('strings.workshop')) !!}
                            </div>
                            <div class="col-md-7">
                                {!! Form::text('workshop_name', null, ['id' => 'name-workshop', 'readonly' ,'class' => 'form-control', 'placeholder' => trans('strings.workshop')]) !!}
                            </div>
                        </div>

                        <br>
                        <br>
                        <div class="row" style="margin-left: 0; margin-right: 0">
                            <div class="col-md-2" style="margin-left: 20px;">
                                {!! Form::label('tutor_id', trans('strings.tutor')) !!}
                            </div>
                            <div class="col-md-7">
                                {!! Form::select('tutor_id', ['' => ''] + $tutors->lists('name', 'id')->all(), null, ['class' => 'tutor-select']) !!}
                            </div>
                        </div>

                        <br>
                        <br>
                        <div class="row" style="margin-left: 0; margin-right: 0">
                            <div class="col-md-2" style="margin-left: 20px;">
                                {!! Form::label('criteria_id', trans('strings.criteria')) !!}
                            </div>
                            <div class="col-md-7">
                                {!! Form::select('criteria_id', ['' => ''] + $criterias->lists('description', 'id')->all(), null, ['class' => 'criteria-select']) !!}
                            </div>
                        </div>

                        <br>
                        <br>
                        <div class="row" style="margin-left: 0; margin-right: 0">
                            <div class="col-md-2" style="margin-left: 20px;">
                                {!! Form::label('activity_id', trans('strings.activity')) !!}
                            </div>
                            <div class="col-md-7">
                                {!! Form::select('activity_id', ['' => ''] + $activities->lists('description', 'id')->all(), null, ['class' => 'activity-select']) !!}
                            </div>
                        </div>
                        
                        <br>
                        <br>
                        <div class="row" style="margin-left: 0; margin-right: 0">
                            <div class="col-md-2" style="margin-left: 20px;">
                                &nbsp;
                            </div>
                            <div class="col-md-7"> 
                                <input type="submit" class="btn btn-success pull-right" value="{{ trans('strings.save_button') }}" />
                            </div>
                        </div>
                        <br><br>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop