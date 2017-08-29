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
        {!! Form::open(array('route' => array('admin.myworkshopevaluations.activitiesreport'), 'class' => 'form-horizontal', 'method' => 'get'))  !!}
        <div class="box-body">
            <div class="row">
                {!! Form::hidden('f_submit', '1'  ) !!}
                <div class="col-md-3" style="margin-top: 5px;">
                    <label>{!! Form::radio('f_Workshop_activities_type_report', '0',($workshopactivityreporttype ===  '0' ? true : false)) !!} {!!trans('strings.reduced')!!} </label> &nbsp;
                    <label>{!! Form::radio('f_Workshop_activities_type_report', '1',($workshopactivityreporttype ===  '1' ? true : false)) !!} Detalhado </label> &nbsp;
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

  {{--  @if($workshopactivityreporttype == '0')
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th width="17%">{{ trans('strings.activity') }}</th>
                    <th width="17%">{{ trans('strings.answered') }}</th>
                    <th width="17%">{{ trans('strings.notanswred') }}</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($myworkshopevaluations as $myworkshopevaluation)
                    <tr>
                        <td>{!! $myworkshopevaluation->workshopActivitiesDescription !!}</td>
                        <td>{!! isset($myworkshopevaluation->answer) ? $myworkshopevaluation->answer->total : "-" !!}</td>
                        <td>{!! isset($myworkshopevaluation->not_answer) ? $myworkshopevaluation->not_answer->total : "-" !!}</td>

                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="pull-left">
            {!! count($myworkshopevaluations) !!} {{ trans('strings.activities') }}
        </div>--}}
    @if($workshopactivityreporttype == '1')
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th colspan="5" style="text-align: center;">{{ trans('strings.workshop') }} | Atividades</th>

                </tr>
            </thead>
            <?php $i = 0; $y = 0; $workshop = NULL; $activity = NULL;?>
            <tbody>
                @foreach ($workshopactivityresults as $myworkshopevaluation)
                    @if($i == 0 || $workshop != $myworkshopevaluation->workshop && $activity != $myworkshopevaluation->activity)
                        <tr style="background-color: #A8BCD7;">
                                <td>{{$myworkshopevaluation->course}} <br>
                                <strong>Oficina:</strong> {{$myworkshopevaluation->workshop}} <br>
                                <strong>Atividade</strong>: {{$myworkshopevaluation->activity}}</td>
                        </tr>
                        <tr><td>Respondido</td></tr>
                    @endif
                    @if($myworkshopevaluation->answered == "C")
                        <tr>
                            <td>
                                <table class="table table-striped table-bordered table-hover" cellpadding="0" cellspacing="0">
                                    <thead>
                                        <th>Aluno</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{$myworkshopevaluation->student}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    @endif
                    @if($y == 0 || $workshop != $myworkshopevaluation->workshop && $activity != $myworkshopevaluation->activity)
                        <tr><td>Não Respondido</td></tr>
                    @endif
                    @if($myworkshopevaluation->answered == "N")
                        <tr>
                            <td style="">
                                {{$myworkshopevaluation->student}}
                            </td>
                        </tr>
                    @endif
                    <?php $i = 1; $y = 1; $workshop = $myworkshopevaluation->workshop; $activity = $myworkshopevaluation->activity;?>
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