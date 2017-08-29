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
        {!! Form::open(array('route' => array('admin.workshopactivitys.activitiesreport'), 'class' => 'form-horizontal', 'method' => 'get'))  !!}
        <div class="box-body">
                {!! Form::hidden('f_submit', '1'  ) !!}
            <div class="row">
                    <label class="col-md-2 control-label">{!!trans('strings.reduced')!!}&nbsp;&nbsp;&nbsp;{!! Form::radio('f_Workshop_activities_type_report', '0',($workshopactivityreporttype ===  '0' ? true : false)) !!}  </label> 
                    <label class="col-md-2 control-label">Detalhado &nbsp;&nbsp;&nbsp;{!! Form::radio('f_Workshop_activities_type_report', '1',($workshopactivityreporttype ===  '1' ? true : false)) !!} </label> &nbsp;
                
            </div>
            <div class="row">
                <label class="col-md-2 control-label">Por atividade &nbsp;&nbsp;&nbsp;{!! Form::radio('f_workshop_activities_group_report', 'A',($workshopactivityreportgroup ===  'A' ? true : false)) !!} </label> &nbsp;
                <label class="col-md-2 control-label">Por Aluno &nbsp;&nbsp;&nbsp;{!! Form::radio('f_workshop_activities_group_report', 'S',($workshopactivityreportgroup ===  'S' ? true : false)) !!}</label> &nbsp;
                
            </div>
            <br>
            <div class="row">
                {!! Form::label('f_workshop_activities_workshop_id',  trans('strings.workshop'), ['class' => 'col-md-2 control-label']) !!}
                <div class="col-md-8">
                    {!! Form::select('f_workshop_activities_workshop_id', ['' => ''] + $workshops->lists('workshop_course', 'Workshop_id')->all(), $workshopactivityworkshopid, ['class' => 'select2']) !!}
                </div>
            </div>
            <br>
        </div>
        <div class="box-footer">
            {!! Form::submit( trans('strings.search'), ['class' => 'btn btn-primary btn-xs']) !!}
        </div>
        {!! Form::close() !!}
    </div>
    <div class="clearfix"></div>

    @if($workshopactivityreporttype == '0')
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th colspan="5" style="text-align: center;">{{ trans('strings.student') }} | {{ trans('strings.course') }} | {{ trans('strings.workshop') }}</th>
                </tr>
            </thead>

            <tbody>
                <?php $sum = 0;?>
                @foreach ($workshopactivityresults as $value)
                    <?php $sum += count($value->corrected) + count($value->answered) + count($value->not_answered);?>
                    <tr>
                        <th style="background-color: #A8BCD7;" colspan="2">Aluno.: {{$value->users_name}} &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; E-mail.: {{$value->users_email}}&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;   Celular.: {{$value->users_cel}} <br> {{$value->oourse_title}} <br>{{$value->workshop_description}}</th>
                        <tr>
                            <td>
                                &nbsp;&nbsp;&nbsp;Corrigidos
                            </td>
                            <td>
                                {{(count($value->corrected) > 0) ? count($value->corrected) : "-"}}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                &nbsp;&nbsp;&nbsp;Respondidos</td>
                            <td>
                                {{(count($value->answered) > 0) ? count($value->answered) : "-"}}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                &nbsp;&nbsp;&nbsp;Não Respondidos
                            </td>
                            <td>
                                {{(count($value->not_answered) > 0) ? count($value->not_answered) : "-"}}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                &nbsp;&nbsp;&nbsp;Total
                            </th>
                            <td>
                                {{$sum}}
                            </td>
                        </tr>
                    </tr>
                    <?php $sum = 0;?>
                @endforeach
            </tbody>
        </table>

        <div class="pull-left">
            {!! count($workshopactivityresults) !!} {{ trans('strings.students') }}
        </div>
    @elseif($workshopactivityreporttype == '1')
        <table class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th colspan="5" style="text-align: center;">{{ trans('strings.student') }} | {{ trans('strings.course') }} | {{ trans('strings.workshop') }}</th>

            </tr>
            </thead>

            <tbody>
            @foreach ($workshopactivityresults as $value)
                <tr style="background-color: #A8BCD7;">
                    <td>{{$value->users_name}} | {{$value->users_email}} | {{$value->users_cel}} <br> {{$value->oourse_title}} <br>{{$value->workshop_description}}</td>
                </tr>
                @if(count($value->corrected) > 0)
                    <tr><td>&nbsp;&nbsp;&nbsp;<strong>Corrigido</strong></td></tr>
                    <tr>
                        <td>
                            <table class="table table-striped table-bordered table-hover" cellpadding="0" cellspacing="0" style="margin-left: 2.3%; width: 95%" >
                                <thead>
                                    <th>Atividade</th>
                                    <th>Data da Correção</th>
                                    <th>Nota</th>
                                </thead>
                                <tbody>
                                    <?php $avg = 0;?>
                                    @foreach($value->corrected as $corrected)
                                        <?php $avg += $corrected->grade; ?>
                                        <tr>
                                            <td>{{$corrected->activity}}</td>
                                            <td>{{format_datebr($corrected->date_evaluation)}}</td>
                                            <td class="text-right">{{number_format($corrected->grade, 2, ',', '.')}}</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td><strong>Média geral do Aluno</strong></td>
                                        <td>&nbsp;</td>
                                        <td class="text-right">{{number_format($avg / count($value->corrected), 2, ',', '.') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                @else
                    <tr><td>&nbsp;&nbsp;&nbsp;<strong>Corrigido</strong></td></tr>
                    <tr>
                        <td>
                            <table cellpadding="0" cellspacing="0" style="margin-left: 2.3%; width: 95%">
                                <tr>
                                    <td>Não existe(m) registro(s)</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                @endif

                @if(count($value->answered) > 0)
                    <tr><td>&nbsp;&nbsp;&nbsp;<strong>Respondido</strong></td></tr>
                    <tr>
                        <td>
                            <table class="table table-striped table-bordered table-hover" cellpadding="0" cellspacing="0" style="margin-left: 2.3%; width: 95%">
                                <thead>

                                    <th>Atividade</th>
                                </thead>
                                <tbody>
                                    @foreach($value->answered as $answered)
                                        <tr>

                                            <td colspan="2">{{$answered->activity}}</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td><strong>Quantidade</strong></td>
                                        
                                        <td>{{count($value->answered)}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                @else
                    <tr><td>&nbsp;&nbsp;&nbsp;<strong>Respondido</strong></td></tr>
                    <tr>
                        <td>
                            <table cellpadding="0" cellspacing="0" style="margin-left: 2.3%; width: 95%">
                                <tr>
                                <td>Não existe(m) registro(s)</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                @endif

                @if(count($value->not_answered) > 0)
                    <tr><td>&nbsp;&nbsp;&nbsp;<strong>Não Respondido</strong></td></tr>
                    <tr>
                        <td>
                            <table class="table table-striped table-bordered table-hover" cellpadding="0" cellspacing="0" style="margin-left: 2.3%; width: 95%">
                                <thead>

                                    <th>Atividade</th>
                                </thead>
                                <tbody>
                                    @foreach($value->not_answered as $not_answered)
                                        <tr>
                                            <td colspan="2">{{$not_answered->activity}}</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td><strong>Quantidade</strong></td>
                                        <td>{{count($value->not_answered)}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                @else
                    <tr><td>&nbsp;&nbsp;&nbsp;<strong>Não Respondido</strong></td></tr>
                    <tr>
                        <td>
                            <table cellpadding="0" cellspacing="0" style="margin-left: 2.3%; width: 95%">
                                <tr>
                                <td>Não existe(m) registro(s)</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                @endif

            @endforeach
            </tbody>
        </table>

        <div class="pull-left">
            {!! count($workshopactivityresults) !!} {{ trans('strings.activities') }}
        </div>
    @endif

    {{-- <div class="pull-right">
        {!! $myworkshopevaluations->render() !!}
    </div>  --}}

    <div class="clearfix"></div>
@stop        