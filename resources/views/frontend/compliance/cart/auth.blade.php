@extends('frontend.layouts.master')

@section('title')
    Identificação | {{app_name()}}
@endsection

@section('content')



<section>
    <div class="container">
        <div class="row">
            <div class="row">
                <div class="col-xs-12">
                    <ul class="nav nav-pills nav-justified thumbnail setup-panel">
                        <li class="disabled"><a>
                            <h4 class="list-group-item-heading">1</h4>
                            <p class="list-group-item-text">Carrinho</p>
                        </a></li>
                        <li class="active"><a>
                            <h4 class="list-group-item-heading">2</h4>
                            <p class="list-group-item-text">Identificação</p>
                        </a></li>
                        <li class="disabled"><a>
                            <h4 class="list-group-item-heading">3</h4>
                            <p class="list-group-item-text">Pagamento</p>
                        </a></li>
                        <li class="disabled"><a>
                            <h4 class="list-group-item-heading">4</h4>
                            <p class="list-group-item-text">Conclusão</p>
                        </a></li>
                    </ul>
                </div>
            </div>




            <section id="steps-container">
                <div class="signup-page">
                    <div class="container">

                        <div class="row">
                            <!-- JA SOU CADASTRADO -->
                            <div class="col-sm-12 col-md-6">
                                <div class="ragister-account account-login">
                                    <h1 class="section-title title">JÁ É CADASTRADO?</h1>
                                    <div class="login-options text-center">
                                        <a href="/auth/login/facebook" class="facebook-login"><i class="fa fa-facebook"></i> Login com Facebook</a>
                                    </div>

                                    {!! Form::open(['id' => "registation-form", 'name' => "registation-form", 'url' => 'auth/login', 'class' => 'form-horizontal', 'role' => 'form']) !!}
                                    {!! Form::hidden('from_cart', 1) !!}

                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                                    <div class="form-group col-xs-12 col-sm-6 col-md-6 pull-left ragister-account-margin">
                                        {!! Form::label('email', trans('validation.attributes.email')) !!}
                                        {!! Form::input('email', 'email', old('email'), ['class' => 'form-control', 'placeholder' => 'Digite o seu login']) !!}
                                    </div>


                                    <div class="form-group col-xs-12 col-sm-6 col-md-6 pull-left ragister-account-margin">
                                        {!! Form::label('password', trans('validation.attributes.password')) !!}
                                        {!! Form::input('password', 'password', null, ['class' => 'form-control']) !!}
                                    </div>

                                    <div style="clear: both;"></div>

                                    <div class="checkbox">
                                        <!--
                                        <label class="pull-let">
                                            <input type="checkbox" name="signing" id="signing"> Manter logado
                                        </label> -->
                                        <a onclick="javascript:$('#forgotModal').modal();" class="btn btn-link text-center center-block">Esqueceu a senha?</a>
                                    </div><!-- checkbox -->

                                    <div class="submit-button text-center">
                                        {!! Form::submit(trans('labels.login_button'), ['class' => 'btn btn-primary']) !!}
                                    </div>
                                    {!!   Form::close() !!}
                                    @include('includes.partials.forgot-password')
                                    </div>
                                </div>






                                <!-- NAO SOU CADASTRADO -->
                                <div class="col-sm-12 col-md-6">
                                    <div class="ragister-account">

                                        <h1 class="section-title title">CADASTRE-SE</h1>
                                        <div class="login-options text-center">
                                            <a href="/auth/login/facebook" class="facebook-login"><i class="fa fa-facebook"></i> Acessar com Facebook</a>
                                        </div>

                                        {!! Form::open([ 'id'=> "registation-form", 'name'=> "registation-form",'url' => 'auth/register', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post']) !!}
                                        {!! Form::hidden('from_cart', 1) !!}
                                        <div class="clearfix"></div>
                                        <div class="form-group col-xs-12 col-sm-12 col-md-12">
                                            {!! Form::label('name', trans('validation.attributes.namesurname')) !!}
                                            {!! Form::input('text', 'name', null, ['class' => 'form-control','placeholder' => "Digite o nome"]) !!}
                                        </div>


                                        <div class="form-group col-xs-12 col-sm-12 col-md-12">
                                            {!! Form::label('email', trans('validation.attributes.email')) !!}
                                            {!! Form::input('email', 'email', old('email'), ['class' => 'form-control', 'placeholder' => 'Digite o seu login']) !!}
                                        </div>



                                        <div class="clearfix"></div>
                                        <div class="form-group col-xs-12 col-sm-6 col-md-6 pull-left ragister-account-margin">
                                            {!! Form::label('password', trans('validation.attributes.password')) !!}
                                            {!! Form::input('password', 'password', null, ['class' => 'form-control']) !!}
                                        </div>
                                        <div class="form-group col-xs-12 col-sm-6 col-md-6 pull-left ragister-account-margin">
                                            {!! Form::label('password_confirmation', trans('validation.attributes.password_confirmation')) !!}
                                            {!! Form::input('password', 'password_confirmation', null, ['class' => 'form-control']) !!}
                                        </div>
                                        <!-- checkbox -->

                                        <div class="clearfix"></div>

                                        @if(!isset($free) )
                                        <div class="form-group col-xs-12 col-sm-6 col-md-6 pull-left ragister-account-margin">
                                            {!! Form::label('gender', trans('strings.gender')) !!}
                                            <div class="clearfix"></div>

                                            <div class="radio-inline">
                                                <label>
                                                    {!! Form::radio('gender', 'M', true) !!}
                                                    {!! trans('strings.male') !!}
                                                </label>
                                            </div>

                                            <div class="radio-inline">
                                                <label>
                                                    {!! Form::radio('gender', 'F') !!}
                                                    {!! trans('strings.female') !!}
                                                </label>
                                            </div>
                                        </div>



                                        <div class="form-group col-xs-12 col-sm-6 col-md-6 pull-left ragister-account-margin">
                                            {!! Form::label('birthdate', trans('strings.birthdate')) !!}
                                            {!! Form::text('birthdate', null, ['class' => 'form-control birthdate', 'placeholder' => trans('strings.birthdate')]) !!}
                                        </div><!--form control-->



                        <div class="clearfix"></div>


                                        <div class="form-group col-xs-12 col-sm-6 col-md-6 pull-left ragister-account-margin">
                                            {!! Form::label('personal_id', trans('strings.personal_id')) !!}
                                            {!! Form::text('personal_id', null, ['class' => 'form-control personal_id', 'placeholder' => trans('strings.personal_id')]) !!}
                                        </div>

                                        <div class="clear-fix"></div>

                                        @endif


                                        <div class="form-group col-xs-12 col-sm-6 col-md-6 pull-left ragister-account-margin">
                                            {!! Form::label('cel', trans('strings.cel')) !!}
                                            {!! Form::text('cel', null, ['class' => 'form-control cel', 'placeholder' => trans('strings.cel')]) !!}
                                        </div><!--form control-->




                                        @if(!isset($free) )
                                            <div class="clearfix"></div>
                                        <div class="form-group col-xs-12 col-sm-12 col-md-4">
                                            @else
                                                <div class="form-group col-xs-12 col-sm-6 col-md-6 pull-left ragister-account-margin">
                                                @endif
                                            {!! Form::label('zip', trans('strings.zip')) !!}
                                            {!! Form::text('zip', null, ['class' => 'form-control zip', 'placeholder' => trans('strings.zip'), 'onblur' => 'javascript:findAddressBrazil($("#zip"), $("#address"));']) !!}
                                        </div><!--form control-->
                                        <div class="form-group col-md-8 ">&nbsp;</div><!--form control-->

                                        <div class="clearfix"></div>


                                        <div class="form-group col-xs-12 col-sm-6 col-md-6  pull-left ragister-account-margin">
                                            {!! Form::label('city', trans('strings.city')) !!}
                                            {!! Form::text('city', null, ['class' => 'form-control', 'disabled' => 'disabled', 'placeholder' => trans('strings.city')]) !!}
                                        </div><!--form control-->

                                        <div class="form-group col-xs-12  col-sm-6 col-md-6 pull-left ragister-account-margin">
                                            {!! Form::label('state', trans('strings.state')) !!}
                                            {!! Form::text('state', null, ['class' => 'form-control', 'disabled' => 'disabled', 'placeholder' => trans('strings.state')]) !!}
                                        </div><!--form control-->

                                        <div class="clearfix"></div>
                                        <div class="form-group checkbox col-md-12">

                                            <label>
                                                <input type="checkbox" value="1" name="signing" id="signing">
                                                Aceito os <a href="#" data-toggle="modal" data-target="#termsUses">termos de uso</a>
                                            </label>
                                            <div class="form-group col-md-12">
                                                <button type="submit" class="btn btn-primary">Continuar</button>
                                            </div>
                                            {!! Form::hidden('city_id', null, ['id' => 'city_id']) !!}
                                        </div><br><br><br><br>






                                        {!!   Form::close() !!}
                                    </div>
                                </div><!-- user-login -->
                            </div><!-- row -->
                        </div><!-- container -->
                    </div><!-- signup-page -->



                </section>






            </div>
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
                    @include('frontend.institutional.compliance-terms')
                </div>
            </div>
        </div>
    </div>

    @endsection