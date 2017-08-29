@extends('frontend.layouts.master')

@section('title')
Complete o seu cadastro | {{app_name()}}
@endsection

@section('content')
<section id="main-content" class="cart-page">
    @if(!isset($free) )
    <div class="container">
        <div class="row form-group">
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
        @endif
        <section id="steps-container" style="margin:0 auto; width: 90%">

            <div class="col-md-10 no-padding">
                <h3 class="title-bj">Complete o seu cadastro</h3>
                {!! Form::model(Auth::user(), ['route' => ['profile.update', Auth::user()->id], 'class' => 'form-identification', 'method' => 'PATCH', 'files' => true]) !!}
                {!! Form::hidden('from_cart', 1) !!}
                <div class="form-group">
                    {!! Form::label('name', trans('validation.attributes.name')) !!}
                    {!! Form::input('text', 'name', null, ['class' => 'form-control','placeholder' => "Digite o nome"]) !!}
                </div>

                <div class="clearfix"></div>
                @if(!isset($free) )
                <div class="form-group col-md-6 no-padding">
                    {!! Form::label('gender', trans('strings.gender')) !!}
                    <div class="clearfix"></div>
                    <div class="radio-inline">
                        <label>
                            {!! Form::radio('gender', 'M', true) !!}
                            {!! trans('strings.male') !!}</label>
                    </div>
                    <div class="radio-inline">
                        <label>
                            {!! Form::radio('gender', 'F') !!}
                            {!! trans('strings.female') !!}</label>
                    </div>
                </div>
                <div class="form-group col-md-6 no-padding">
                    {!! Form::label('birthdate', trans('strings.birthdate')) !!}
                    {!! Form::text('birthdate', null, ['class' => 'form-control birthdate', 'placeholder' => trans('strings.birthdate')]) !!}
                </div>
                <div class="clearfix"></div>
                <div class="form-group col-md-6 no-padding">
                    {!! Form::label('personal_id', trans('strings.personal_id'), ['class' => 'col-md-3 control-label']) !!}
                    {!! Form::text('personal_id', null, ['class' => 'form-control personal_id', 'placeholder' => trans('strings.personal_id')]) !!}
                </div>
                @endif
                <div class="form-group col-md-6 no-padding">
                    {!! Form::label('cel', trans('strings.cel')) !!}
                    {!! Form::text('cel', null, ['class' => 'form-control cel', 'placeholder' => trans('strings.cel')]) !!}
                </div><!--form control-->
                <div class="clearfix"></div>
                <div class="form-group">
                    {!! Form::label('zip', trans('strings.zip')) !!}
                    {!! Form::text('zip', null, ['class' => 'form-control zip', 'placeholder' => trans('strings.zip'), 'onblur' => 'javascript:findAddressBrazil($("#zip"), $("#address"));']) !!}
                </div><!--form control-->
                {!! Form::hidden('city_id', null, ['id' => 'city_id']) !!}
                <div class="form-group col-md-6 no-padding">
                    {!! Form::label('city', trans('strings.city')) !!}
                    {!! Form::text('city', null, ['class' => 'form-control', 'disabled' => 'disabled', 'placeholder' => trans('strings.city')]) !!}
                </div><!--form control-->
                <div class="form-group col-md-6 no-padding">
                    {!! Form::label('state', trans('strings.state')) !!}
                    {!! Form::text('state', null, ['class' => 'form-control', 'disabled' => 'disabled', 'placeholder' => trans('strings.state')]) !!}
                </div><!--form control-->
                <button type="submit" class="btn btn-primary">Continuar</button>
                {!!  Form::close()  !!}
            </div>
        </section>
    </div>
</section>
<br>
<br>

@endsection