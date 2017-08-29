@extends('frontend.layouts.master')

@section('title')
    Inscrição | {{app_name()}}
@endsection

@section('content')

    <section id="main-content">
        <div class="container">
            @if( isset($error))
                <span style="color: red;">{!! $error  !!}</span>
                <br/>
                <br/>
            @endif

            <img src="{{ imageurl('partners/',$preenrollment->partner->id, $preenrollment->partner->logo, 0, 'generic.png', false) }}">
            <br/>
            <br/>
            <b>Prezado(a) aluno(a) {{ explode(" ", $preenrollment->student->name)[0] }},</b>
            <br/>
            <br/>
            @if ($preenrollment->date_activation != null)
                Esta pré-matricula já foi confirmada. Por favor, faça o login e inicie seu curso!
                    <br/>
                    <br/>
            @else
                {!!   $preenrollment->partnerorder->html_subscribe !!}
                <br/>
                <br/>
                    {!! Form::open(['url' => 'preenrollment/subscribe', 'class' => 'form-identification', 'role' => 'form']) !!}
                    {!! Form::hidden('subscribe_key', $preenrollment->subscribe_key, ['id' => 'subscribe_key']) !!}
                    Prazo para inscrição: <b>{{ format_datebr($preenrollment->date_deadline) }}</b>
                    <br/>
                    <br/>
                    Seja bem vindo e bons estudos!
                    <br/>
                    <br/>
                    <b>Equipe Brasil Jurídico</b>
                    <br/>
                    <br/>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="terms_accepted" value="1" >
                            Aceito os <a href="#" data-toggle="modal" data-target="#termsUses">termos de uso</a>
                        </label>
                    </div>
                    @if (($preenrollment->student->confirmed == 0) || ($preenrollment->student->password == null) || ($preenrollment->student->password == ''))
                    <div class="form-group" >
                        <label for="inputPassword">Senha que usará no Brasil Jurídico
                        <br>(mínimo de 6 caracteres)
                        </label>
                        {!! Form::input('password', 'password', null, ['id' => 'inputPassword', 'class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        <label for="inputPassword">Repita a senha</label>
                        {!! Form::input('password', 'rpassword', null, ['id' => 'rinputPassword', 'class' => 'form-control']) !!}
                    </div>

                @else
                    <div class="form-group">
                        <label for="inputPassword">Entre a sua senha existente</label>
                        {!! Form::input('password', 'password', null, ['id' => 'inputPassword', 'class' => 'form-control']) !!}
                    </div>
                @endif
                <button type="submit" class="btn btn-primary">Confirmar</button>
                {!!  Form::close()  !!}
            @endif
            <br/>
            <br/>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="termsUses" tabindex="-1" role="dialog" aria-labelledby="termsLabel">
        <div class="modal-dialog  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Termos de Uso</h4>
                </div>
                <div class="modal-body">
                    @include('frontend.institutional.terms-content')
                </div>

            </div>
        </div>
    </div>

@endsection