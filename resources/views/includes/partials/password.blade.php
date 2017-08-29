<div class="modal fade" id="passwordModal" tabindex="-1" role="dialog" aria-labelledby="passwordModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="passwordModalLabel"><strong>{!! trans('labels.change_password_box_title') !!}</strong></h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['route' => ['password.change'], 'class' => 'form-horizontal']) !!}

                <div class="form-group">
                    {!! Form::label('old_password', trans('validation.attributes.old_password'), ['class' => 'col-md-4 control-label']) !!}
                    <div class="col-md-6">
                        {!! Form::input('password', 'old_password', null, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('password', trans('validation.attributes.new_password'), ['class' => 'col-md-4 control-label']) !!}
                    <div class="col-md-6">
                        {!! Form::input('password', 'password', null, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('password_confirmation', trans('validation.attributes.new_password_confirmation'), ['class' => 'col-md-4 control-label']) !!}
                    <div class="col-md-6">
                        {!! Form::input('password', 'password_confirmation', null, ['class' => 'form-control']) !!}
                    </div>
                </div>



            </div>
            <div class="modal-footer">
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        {!! Form::submit(trans('labels.change_password_button'), ['class' => 'btn btn-primary']) !!}
                    </div>
                </div>

                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>