@extends('frontend.layouts.master-classroom')

@section('content')

    <section role="main" class="content-body">
        <header class="page-header">
            <h2>Meus Dados </h2>
        </header>

        <!-- start: page -->
        @include('includes.partials.messages')

        <div id="white-feed">
            <div class="container">
                <div class="section">
                    <div class="row">

                        <section class="panel">
                            <div class="panel-body">
                                <div class="col-md-1">  </div>


                                <div class="">
                                    {!! Form::model($user, ['route' => ['profile.update', $user->id], 'class' => 'form-horizontal ', 'method' => 'PATCH', 'files' => true]) !!}



                                    <div class="col-md-3">
                                        <div class="thumb-Info-Perfil text-center">
                                            <div class="thumb-info mb-md ">{!! HTML::image($photoresize) !!} </div>

                                            <div style="height:0px;overflow:hidden">
                                                <input type="file" id="photo" name="photo" />
                                            </div>
                                            <button class="btn btn-primary" type="button" onclick="javascript:$('#photo').click();">Selecione a foto</button>

                                        </div>



                                    </div><!-- /.col -->


                                    <div class="col-md-8">

                                        <div class="form-group">
                                            {!! Form::label('name', trans('validation.attributes.name'), ['class' => 'col-md-3 control-label']) !!}
                                            <div class="col-md-6">
                                                {!! Form::input('text', 'name', null, ['class' => 'form-control']) !!}
                                            </div>
                                        </div>




                                        <div class="form-group">
                                            {!! Form::label('email', trans('validation.attributes.email'), ['class' => 'col-md-3 control-label']) !!}
                                            <div class="col-md-6">
                                                {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.email')]) !!}
                                            </div>
                                        </div><!--form control-->

                                        <div class="form-group">
                                            {!! Form::label('gender', trans('strings.gender'), ['class' => 'col-md-3 control-label']) !!}
                                            <div class="col-md-6">
                                                <div class="radio-custom radio-primary pull-left">
                                                    {!! Form::radio('gender', 'M', true) !!}
                                                    <label>{!! trans('strings.male') !!}</label>&nbsp;&nbsp;&nbsp;
                                                </div>
                                                <div class="radio-custom radio-primary pull-left">
                                                    {!! Form::radio('gender', 'F') !!}
                                                    <label>{!! trans('strings.female') !!}</label>
                                                </div>

                                            </div>
                                        </div><!--form control-->

                                        <div class="form-group">
                                            {!! Form::label('cel', trans('strings.cel'), ['class' => 'col-md-3 control-label']) !!}
                                            <div class="col-md-6">
                                                {!! Form::text('cel', null, ['class' => 'form-control cel', 'placeholder' => trans('strings.cel')]) !!}
                                            </div>
                                        </div><!--form control-->

                                        <div class="form-group">
                                            {!! Form::label('birthdate', trans('strings.birthdate'), ['class' => 'col-md-3 control-label']) !!}
                                            <div class="col-md-6">
                                                {!! Form::text('birthdate', null, ['class' => 'form-control birthdate', 'placeholder' => trans('strings.birthdate')]) !!}
                                            </div>
                                        </div><!--form control-->


                                        <div class="form-group">
                                            {!! Form::label('personal_id', trans('strings.personal_id'), ['class' => 'col-md-3 control-label']) !!}
                                            <div class="col-md-6">
                                                {!! Form::text('personal_id', null, ['class' => 'form-control personal_id', 'placeholder' => trans('strings.personal_id')]) !!}
                                            </div>
                                        </div><!--form control-->

                                        <div class="form-group">
                                            {!! Form::label('zip', trans('strings.zip'), ['class' => 'col-md-3 control-label']) !!}
                                            <div class="col-md-6">
                                                {!! Form::text('zip', null, ['class' => 'form-control zip', 'placeholder' => trans('strings.zip'), 'onblur' => 'javascript:findAddressBrazil($("#zip"), $("#address"));']) !!}
                                            </div>
                                        </div><!--form control-->

                                        {!! Form::hidden('city_id', $city->id, ['id' => 'city_id']) !!}

                                        <div class="form-group">
                                            {!! Form::label('city', trans('strings.city'), ['class' => 'col-md-3 control-label']) !!}
                                            <div class="col-md-6">
                                                {!! Form::text('city', $city->name, ['class' => 'form-control', 'disabled' => 'disabled', 'placeholder' => trans('strings.city')]) !!}
                                            </div>
                                        </div><!--form control-->

                                        <div class="form-group">
                                            {!! Form::label('state', trans('strings.state'), ['class' => 'col-md-3 control-label']) !!}
                                            <div class="col-md-6">
                                                {!! Form::text('state', $state->short, ['class' => 'form-control', 'disabled' => 'disabled', 'placeholder' => trans('strings.state')]) !!}
                                            </div>
                                        </div><!--form control-->

                                        {{--<div class="form-group">--}}
                                                {{--{!! Form::label('occupation', trans('strings.occupation'), ['class' => 'col-md-3 control-label']) !!}--}}
                                            {{--<div class="col-md-6">--}}
                                                {{--{!! Form::select('occupations[]', [''=>''] + $occupations->lists('description', 'id')->all(), $user->occupation_id, ['class' => 'form-control select2', 'placeholder' => trans('strings.occupation') ])  !!}--}}
                                            {{--</div>--}}
                                        {{--</div><!--form control-->--}}


                                        <div class="form-group">
                                            {!! Form::label('state', "Estudo diário", ['class' => 'col-md-3 control-label']) !!}
                                            <div class="col-md-6">
                                                <input id="planstudy_hours" type="text" value="{{ $studyplanhours }}" name="planstudy_hours" class="form-control planstudy_hours">
                                            </div>
                                        </div><!--form control-->

                                        <div class="form-group">
                                            {!! Form::label('video_quality', trans('strings.video_quality'), ['class' => 'col-md-3 control-label']) !!}
                                            <div class="col-md-6">
                                                {!! Form::radio('video_quality', '0', true,["data-toggle"=>"tooltip", "title"=>"Carrega o vídeo na melhor qualidade suportada pela sua conexão."]) !!}  {!! trans('strings.auto') !!}
                                                &nbsp;&nbsp;{!! Form::radio('video_quality', '1',false,["data-toggle"=>"tooltip", "title"=>"Carrega o vídeo com a menor qualidade possível. Recomendado para quem tem banda limitada."]) !!} {!! trans('strings.low') !!}
                                            </div>
                                            
                                        </div><!--form control-->


                                        {{--@if ($user->canChangeEmail())--}}
                                        {{--<div class="form-group">--}}
                                        {{--{!! Form::label('email', trans('validation.attributes.email'), ['class' => 'col-md-3 control-label']) !!}--}}
                                        {{--<div class="col-md-6">--}}
                                        {{--{!! Form::input('email', 'email', null, ['class' => 'form-control']) !!}--}}
                                        {{--</div>--}}
                                        {{--</div>--}}
                                        {{--@endif--}}
                                        <div class="row">
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    {!! Form::submit(trans('labels.update_button'), ['class' => 'btn btn-success']) !!}
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#passwordModal">{!! trans('labels.change_password_button') !!}
                                                    </button>

                                                    <a class="btn btn-primary" href="{{ Route('student.orders') }}">Meus pedidos</a>
                                                    <a type="button" href="" class="mb-xs mt-xs mr-xs btn default"  data-toggle="modal" data-target="#termsUses"><i class="fa fa-exclamation-circle"></i>&nbsp;&nbsp;Termos de Uso</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!--panel body-->


                                </div>


                                {!! Form::close() !!}




                                @include('includes.partials.password')

                            </div><!--panel body-->

                        </section><!-- col-md-10 -->

                    </div>
                </div>
            </div>
        </div><!--/#main-wrapper-->
        
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
    </section><!-- row -->
@endsection