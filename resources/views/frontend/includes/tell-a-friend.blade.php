<div class="modal fade" id="tellAFriendModal" tabindex="-1" role="dialog" aria-labelledby="termsLabel">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div id="tabs-content" class="modal-content">
                <section id="tell-a-friend-form" class="panel">
                    <div class="panel-body" style='height: 100%;'>
                        <div class="col-md-12">
                            <div style="padding-top: 0 !important;padding-bottom: 5px;margin-bottom: 0px;">
                                <div class="row">
                                    <div class="col-md-11">
                                        <h1 class="section-title title">Indique esse {{ $type }} a seus amigos</h1>
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                </div>
                                {!! Form::open(['route' => 'frontend.tell-a-friend', 'id' => 'tellAFriendForm', 'class' => 'form-horizontal', 'role' => 'form', 'style' => 'padding:20px']) !!}

                                    {!! Form::hidden('type',$type) !!}
                                    {!! Form::hidden('type-id',$id) !!}
                                    {!! Form::hidden('route',$route) !!}

                                    <div class="form-group">
                                        {!! Form::label('name', trans('validation.attributes.your_name'), []) !!}
                                        {!! Form::input('name', 'name', old('name'), ['class' => 'form-control']) !!}
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label('email', trans('validation.attributes.your_email'), []) !!}
                                        {!! Form::input('email', 'email', old('email'), ['class' => 'form-control e-mail']) !!}
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label('message', trans('validation.attributes.tell-a-friend')) !!}
                                        {!! Form::textarea('message','Seu amigo indica ' .  $suggestion_name  . ' que irá contribuir para o seu sucesso. ',['rows' => 5, 'class' => 'form-control textarea', 'placeholder' => 'Deixe aqui sua mensagem']) !!}
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label('friends',trans('validation.attributes.friends')) !!}
                                        {!! Form::email('friends',null,['class' => 'form-control select2','multiple' => 'multiple']) !!}
                                    </div>

                                    <div class="form-group">
                                        {!! Form::submit( trans('strings.send'), ['class' => 'btn btn-primary btn-tell']) !!}
                                    </div>

                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>

<!-- Moda de tela caso o cadastro foi com sucesso. -->
<div class="modal fade" id="tellAFriendModalClose" tabindex="-1" role="dialog" aria-labelledby="termsLabel">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
                <div id="tabs-content" class="modal-content">
                <section id="tell-a-friend-form" class="panel">
                    <div class='row'>
                        <div class='col-md-11'>
                            <h2 style='padding:20px'>Sua indicação foi enviada com sucesso!</h2>
                        </div>
                        <div class='col-md-1'>  
                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>