<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <h1 style="color:black"><strong>| TE CONHECENDO</strong> melhor</h1>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="card" style="margin-bottom: 20px; height: 170px;">
                    Com o propósito de te auxiliar melhor no caminho dos seus objetivos, gostaríamos
                    de saber um pouco mais sobre você!
                    <br>

                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="card" style="margin-bottom: 20px; height: 170px;">
                    <b>Qual a sua ocupação?</b>
                    <br>
                    <br>
                    {!! Form::open(['route' => ['frontend.profile.occupation'], 'id' => 'occupation_form', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'POST']) !!}
                    {!! Form::select('occupations[]', [''=>''] + $occupations->lists('description', 'id')->all(), null, ['class' => 'form-control select2', 'placeholder' => trans('strings.occupation') ])  !!}
                    <br>
                    <br>
                    {!! Form::submit(trans('labels.update_button'), ['class' => 'btn btn-success']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
