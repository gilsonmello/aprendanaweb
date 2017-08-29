@extends ('backend.layouts.master')

@section ('name', trans('menus.myworkshopevaluations'))

@section('page-header')
    <h1>
        {{ trans('menus.myworkshopevaluations') }}
        <small>{{ trans('menus.all_myworkshopevaluations') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.myworkshopevaluations.index', trans('menus.myworkshopevaluations')) !!}</li>
@stop

@section('content')
    
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Filtro</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        {!! Form::open(array('route' => array('admin.myworkshopevaluations.index'), 'class' => 'form-horizontal', 'method' => 'get'))  !!}
        <div class="box-body">
            <div class="row">
                {!! Form::hidden('f_submit', '1'  ) !!}
                    {!! Form::label('f_MyWorkshopEvaluationController_date_begin',  trans('strings.deadline_date_begin'), ['class' => 'col-md-1 control-label']) !!}
                <div class="col-md-2">
                    {!! Form::text('f_MyWorkshopEvaluationController_date_begin', $evaluationdeadlinebegin, ['class' => 'datemask form-control', 'style' => 'width:80%; display:inline-block;margin-right:10px;']) !!}
                    <strong>{{trans('strings.registration_date_end')}}</strong>
                </div>
                <div class="col-md-3">
                    {!! Form::text('f_MyWorkshopEvaluationController_date_end', $evaluationdeadlineend, ['class' => 'datemask form-control', 'style' => 'width:80%;'] ) !!}
                </div>

                <div class="col-md-4" style="width: 21%">
                {!! Form::label('f_MyWorkshopEvaluationController_evaluated',  trans('strings.report_exhibition'), ['class' => 'col-md-7 control-label', 'style' => 'width: 100%']) !!}
                </div>
                <div class="col-md-3 no-padding" style="margin-top: 5px;">
                    <label>{!! Form::radio('f_MyWorkshopEvaluationController_evaluated', '2',($evaluationevaluated ===  '2' ? true : false)) !!} {!!trans('strings.all')!!} </label> &nbsp;<br>
                    <label>{!! Form::radio('f_MyWorkshopEvaluationController_evaluated', '1',($evaluationevaluated ===  '1' ? true : false)) !!} Apenas atividades corrigidas </label> &nbsp;
                    <label>{!! Form::radio('f_MyWorkshopEvaluationController_evaluated', '0',($evaluationevaluated ===  '0' ? true : false)) !!} Apenas alunos que enviaram resposta (não corrigidas) </label>
                </div>
            </div>
            <br>
            @if (sizeof($myworkshopevaluationworkshops) != 0)
                <div class="row">
                        {!! Form::label('f_MyWorkshopEvaluationController_workshop_id', trans('strings.workshop'), ['class' => 'col-md-1 control-label']) !!}
                    <div class="col-md-5">
                        {!! Form::select('f_MyWorkshopEvaluationController_workshop_id', array('' => trans('strings.all_female') ) + ($myworkshopevaluationworkshops->lists('workshop_course', 'Workshop_id')->all()), $evaluationworkshopid, ['class' => 'select2']) !!}
                    </div>

                    <div class="col-md-4" style="width: 21%">
                        {!! Form::label('f_MyWorkshopEvaluationController_order_by',  trans('strings.order_by'), ['class' => 'col-md-7 control-label', 'style' => 'width: 100%']) !!}
                        </div>
                    <div class="col-md-3 no-padding" style="margin-top: 5px;">
                        <label>{!! Form::radio('f_MyWorkshopEvaluationController_order_by', '0',($myworkshopevaluationorderby ===  '0' ? true : false)) !!} {!!trans('strings.deadline_for_evaluation')!!} </label> &nbsp;<br>
                        <label>{!! Form::radio('f_MyWorkshopEvaluationController_order_by', '1',($myworkshopevaluationorderby ===  '1' ? true : false)) !!}  {!!trans('strings.activity')!!} e {!!trans('strings.student')!!}</label> &nbsp;
                        <label>{!! Form::radio('f_MyWorkshopEvaluationController_order_by', '2',($myworkshopevaluationorderby ===  '2' ? true : false)) !!} {!!trans('strings.date_response_sent')!!} </label>
                    </div>


                </div>
            @endif
            <br>
            <div class="row">
                {!! Form::label('f_MyWorkshopEvaluationController_student_name',  trans('strings.student'), ['class' => 'col-md-1 control-label']) !!}&nbsp;&nbsp;&nbsp;&nbsp;
                <div class="col-md-5">
                    {!! Form::text('f_MyWorkshopEvaluationController_student_name', $evaluationstudentname, ['class' => 'form-control']) !!}&nbsp;&nbsp;&nbsp;&nbsp;
                </div>
                <div class="col-md-2">
                    <div >
                        <div class="sw-green create-permissions-switch">
                            <div class="onoffswitch">
                                <label class="control-label">{{ trans('validation.attributes.export_to_csv') }}</label>
                                <input type="checkbox" value="1" name="f_MyWorkshopEvaluationController_export_to_csv" class="toggleBtn onoffswitch-checkbox" id="export_to_csv" >
                                <label for="export_to_csv" class="onoffswitch-label">
                                    <div class="onoffswitch-inner"></div>
                                    <div class="onoffswitch-switch"></div>
                                </label>
                            </div>
                        </div><!--green checkbox-->
                    </div>
                </div>
            </div>
            <div class="row">
                {!! Form::label('f_MyWorkshopEvaluationController_question',  trans('strings.activity'), ['class' => 'col-md-1 control-label']) !!}&nbsp;&nbsp;&nbsp;&nbsp;
                <div class="col-md-5">
                    {!! Form::text('f_MyWorkshopEvaluationController_question', $evaluationactivity, ['class' => 'form-control']) !!}&nbsp;&nbsp;&nbsp;&nbsp;
                </div>
            </div>
        </div>
        <div class="box-footer">
            {!! Form::submit( trans('strings.search'), ['class' => 'btn btn-primary btn-xs']) !!}
        </div>
        {!! Form::close() !!}
    </div>
    <div class="clearfix"></div>

    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th width="17%">{{ trans('strings.student') }}</th>
                <th width="17%">{{ trans('strings.tutor') }}</th>
                <th width="17%">{{ trans('strings.activity') }}</th>
                <th width="15%">{{ trans('strings.criteria') }}</th>
                <th width="8%">{{ trans('strings.deadline') }}</th>
                <th width="8%">{{ trans('strings.evaluation') }}</th>
                <th width="4%">{{ trans('strings.grade') }}</th>
                <th width="5%">{{ trans('crud.actions') }}</th>
            </tr>
        </thead>
        
        <tbody>
            @foreach ($myworkshopevaluations as $myworkshopevaluation)
                <tr>
                    <td>{!! $myworkshopevaluation->myActivity->enrollment->student->name !!}</td>
                    <td>{!! $myworkshopevaluation->tutor->name !!}</td>
                    <td>
                        @if(isset($myworkshopevaluation->myActivity->activity->workshop->description))
                        {!! $myworkshopevaluation->myActivity->activity->workshop->description . ' - ' . $myworkshopevaluation->myActivity->activity->description !!}
                        @endif
                    </td>
                    <td>{!! $myworkshopevaluation->criteria->description !!}</td>
                    <td>{!! $myworkshopevaluation->date_deadline !!}</td>
                    <td>{!! $myworkshopevaluation->date_evaluation  !!}</td>
                    <td>{!! $myworkshopevaluation->grade != null ? str_replace('.',',',$myworkshopevaluation->grade) : "" !!}</td>
                    <td>{!! $myworkshopevaluation->action_buttons !!}</td>
                    <td style="display: none;" id="{{$myworkshopevaluation->id}}"></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="pull-left">
        {!! $myworkshopevaluations->total() !!} {{ trans('crud.myworkshopevaluations.total') }}
    </div>

    <div class="pull-right">
        {!! $myworkshopevaluations->render() !!}
    </div>

    <div class="clearfix"></div>

    <div class="modal fade" id="modalEditTutorActivity" tabindex="-1" role="dialog" >
        <div class="modal-dialog" role="document" style="width: 80%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="groupSubjectLabel" style="color: #08C">Alterar tutor da atividade {{-- {{ $lesson->sequence }} --}}</h4>
                    <h4 class="modal-title" id="savedGroupLabel" style="color: #08C; display:none"> Grupo atualizado! </h4>
                </div>

                <div class="modal-body">
                    <form id="editTutorActivity" class="form-horizontal">
                        <div id="dynamic-flash">
                        </div>
                        
                        <br>
                        <br>
                        <div class="row" style="margin-left: 0; margin-right: 0">
                            <div class="col-md-2" style="margin-left: 20px;">
                                {!! Form::label('name', trans('strings.name')) !!}
                            </div>
                            <div class="col-md-7">
                                {!! Form::text(null, null, ['id' => 'name-user', 'readonly' ,'class' => 'form-control', 'placeholder' => trans('strings.name')]) !!}
                            </div>
                        </div>

                        <br>
                        <br>
                        <div class="row" style="margin-left: 0; margin-right: 0">
                            <div class="col-md-2" style="margin-left: 20px;">
                                {!! Form::label('activity', trans('strings.activity')) !!}
                            </div>
                            <div class="col-md-7">
                                {!! Form::text(null, null, ['id' => 'description-workshop', 'readonly' ,'class' => 'form-control', 'placeholder' => trans('strings.workshop')]) !!}
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
                        {{--
                        <div class="row" style="margin-left: 0; margin-right: 0">
                            <div class="col-md-2" style="margin-left: 20px;">
                                {!! Form::label('activity_id', trans('strings.activity')) !!}
                            </div>
                            <div class="col-md-7">
                                {!! Form::select('activity_id', ['' => ''] + $activities->lists('description', 'id')->all(), null, ['class' => 'activity-select']) !!}
                            </div>
                        </div> --}}
                        
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