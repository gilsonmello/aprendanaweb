@if($study_plan != false)
    <div id="study-achievements" data-study-time="{{ $study_plan->daily_time }}" class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-content" style="float: unset">
                    <div class="row">
                        <div class="col-md-6">
                            <strong id="progress-by-title">Horas Assistidas nos últimos 8 dias</strong>
                        </div>
                        <div id="daily-progress" class="col-md-2 progress-title"  style="cursor:pointer; font-weight: bold">
                            Dia
                        </div>
                        <div id="weekly-progress" class="col-md-2 progress-title" style="cursor:pointer">
                            Semana
                        </div>
                        <div id="monthly-progress" class="col-md-2 progress-title" style="cursor:pointer">
                            Mês
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div id="canvas-container" class="container">
                                <div id="canvas-wrapper" class="wrapper">
                                    <canvas id="study-plan-continuous"  class="study-continuous-graph"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@else
    <div id="study-achievements" class="row">
        <div class="col-md-12 text-center" style="
                                  padding: 100px;
                                  vertical-align: middle;
                                  background-image: url('/img/system/dashboard_hours.png');
                                    background-size:cover;">
            <div class="card col-md-4" style="width: 300px;">
                <div class="card-content  text-center">
                    <p><h3><strong>META DIARIA</strong></h3></p>
                    <p style="padding-top: 20px;"><h4>QUANTAS HORAS DIÁRIAS DE VÍDEO AULA VOCÊ PRETENDE ASSISTIR?</h4></p>
                    {!! Form::open(['route' => ['frontend.initialize_study_plan'], 'id' => 'planstudy_form', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'POST']) !!}
                    <input id="planstudy_hours" type="text" value="3" name="planstudy_hours" class="form-control input-lg planstudy_hours">
                    <a type="button" onclick="javascript: $('#planstudy_form').submit();" class="mb-xs mt-xs mr-xs btn btn-default" style="width:100%; border-color: #949398; color:#626471"><i class="fa fa-check"></i>&nbsp;&nbsp;CONFIRMAR</a>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endif