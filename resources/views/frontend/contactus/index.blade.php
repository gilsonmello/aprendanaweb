@extends ('frontend.layouts.master')

@section('title')
    Fale Conosco | {{app_name()}}
@endsection

@section('content')

    <section id="main-content">
        <div class="container">
            <section id="search-meaning">
                <h1 class="section-title">Fale Conosco</h1>
                <p class="meaning-text">Entre em contato com o Brasil Jurídico</p>
            </section>

            <div class="row">
              <div class="col-md-9 no-padding">
                    {{--<br/>--}}
                    {{--<p style="padding-left: 100px;"> Verifique se sua dúvida pode ser esclarecida na seção de <a href="{{route('faqs')}}">Perguntas Frequentes (FAQ)</a>.</p>--}}
                  <br/>
                  <p style="padding-left: 100px;">Caso você já seja um aluno do Brasil Jurídico, para um atendimento mais eficiente, acesse <a href="/auth/login">Área do Aluno</a> e abra um chamado.</p>

                    {!! Form::open(['route' => ['contactus.show'], 'class' => 'form-horizontal', 'style' => 'margin-top:30px;padding:20px;', 'role' => 'form', 'method' => 'POST']) !!}

        <div class="form-group">
            {!! Form::label('name', trans('validation.attributes.name'), ['class' => 'col-md-2 control-label']) !!}
            <div class="col-md-10">
                {!! Form::text('name', null, ['class' => 'form-control']) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('email', trans('Email'), ['class' => 'col-md-2 control-label']) !!}
            <div class="col-md-10">
                {!! Form::text('email', null, ['class' => 'form-control']) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('sectors', trans('strings.subject'), ['class' => 'col-md-2 control-label']) !!}
            <div class="col-md-10">
                {!! Form::select("sectors[]",$sector->lists("name","id"), null, ['class' => 'form-control select2', 'placeholder' => trans('strings.choice_sector') ])  !!}
            </div>
        </div>


        <div class="form-group">
            {!! Form::label('message', trans('validation.attributes.message'), ['class' => 'col-md-2 control-label']) !!}
            <div class="col-md-10">
                {!! Form::textarea('message', null, ['class' => 'form-control']) !!}
            </div>
        </div>
        <!--form control-->
         <div class="pull-right">
            <input type="submit" class="btn btn-success" value="{{ trans('strings.send') }}" />
        </div>
        <div class="clearfix"></div>

        {!! Form::close() !!}


              </div>

            </div>
        </div>
    </section>

@endsection