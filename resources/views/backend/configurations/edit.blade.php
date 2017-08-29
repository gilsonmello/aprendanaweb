@extends ('backend.layouts.master')

@section ('title', trans('menus.configuration_management') . ' | ' . trans('menus.create_configuration'))

@section('page-header')
    <h1>
        {{ trans('menus.configurations') }}
        <small>{{ trans('menus.edit_configuration') }}</small>
    </h1>
@endsection


@section('content')
<br/>
    {!! Form::model($configuration, ['route' => ['admin.configurations.update', $configuration->id], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH']) !!}

<div class="form-group">
    {!! Form::label('email_contact_us', trans('strings.email_contact_us'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('email_contact_us', null, ['class' => 'form-control', 'placeholder' => trans('strings.email_contact_us')]) !!}
    </div>
</div><!--form control-->

<div class="form-group">
    {!! Form::label('youtube', trans('strings.youtube'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('youtube', null, ['class' => 'form-control', 'placeholder' => trans('strings.youtube')]) !!}
    </div>
</div><!--form control-->

<div class="form-group">
    {!! Form::label('twitter', trans('strings.twitter'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('twitter', null, ['class' => 'form-control', 'placeholder' => trans('strings.twitter')]) !!}
    </div>
</div><!--form control-->

<div class="form-group">
    {!! Form::label('facebook', trans('strings.facebook'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('facebook', null, ['class' => 'form-control', 'placeholder' => trans('strings.facebook')]) !!}
    </div>
</div><!--form control-->

<div class="form-group">
    {!! Form::label('instagram', trans('strings.instagram'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('instagram', null, ['class' => 'form-control', 'placeholder' => trans('strings.instagram')]) !!}
    </div>
</div><!--form control-->

<div class="form-group">
    {!! Form::label('pagseguro_token', trans('strings.pagseguro_token'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('pagseguro_token', null, ['class' => 'form-control', 'placeholder' => trans('strings.pagseguro_token')]) !!}
    </div>
</div><!--form control-->

<div class="form-group">
    {!! Form::label('pagseguro_email', trans('strings.pagseguro_email'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('pagseguro_email', null, ['class' => 'form-control', 'placeholder' => trans('strings.pagseguro_email')]) !!}
    </div>
</div><!--form control-->

<div class="form-group">
    {!! Form::label('smtp', trans('strings.smtp'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('smtp', null, ['class' => 'form-control', 'placeholder' => trans('strings.smtp')]) !!}
    </div>
</div><!--form control-->

<div class="form-group">
    {!! Form::label('smtp_user', trans('strings.smtp_user'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('smtp_user', null, ['class' => 'form-control', 'placeholder' => trans('strings.smtp_user')]) !!}
    </div>
</div><!--form control-->

<div class="form-group">
    {!! Form::label('smtp_password', trans('strings.smtp_password'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::password('smtp_password', ['class' => 'form-control']) !!}
    </div>
</div><!--form control-->

<div class="form-group">
    {!! Form::label('smtp_port', trans('strings.smtp_port'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('smtp_port', null, ['class' => 'form-control', 'placeholder' => trans('strings.smtp_port')]) !!}
    </div>
</div><!--form control-->

<div class="form-group">
    {!! Form::label('percentage_count_video_view', trans('strings.percentage_count_video_view'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('percentage_count_video_view', null, ['class' => 'form-control', 'placeholder' => trans('strings.percentage_count_video_view')]) !!}
    </div>
</div><!--form control-->

<div class="form-group">
    {!! Form::label('video_views', trans('strings.video_views'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('video_views', null, ['class' => 'form-control', 'placeholder' => trans('strings.video_views')]) !!}
    </div>
</div><!--form control-->

<div class="form-group">
    {!! Form::label('percentage_certificate', trans('strings.percentage_certificate'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('percentage_certificate', null, ['class' => 'form-control', 'placeholder' => trans('strings.percentage_certificate')]) !!}
    </div>
</div><!--form control-->

<div class="form-group">
    {!! Form::label('percetage_share_teachers', trans('strings.percetage_share_teachers'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('percetage_share_teachers', null, ['class' => 'form-control', 'placeholder' => trans('strings.percetage_share_teachers')]) !!}
    </div>
</div><!--form control-->

<div class="form-group">
    {!! Form::label('operational_cost', trans('strings.operational_cost'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('operational_cost', null, ['class' => 'form-control', 'placeholder' => trans('strings.operational_cost')]) !!}
    </div>
</div><!--form control-->


<div class="form-group">
    {!! Form::label('taxes', trans('strings.taxes'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('taxes', null, ['class' => 'form-control', 'placeholder' => trans('strings.taxes')]) !!}
    </div>
</div><!--form control-->

<div class="form-group">
    {!! Form::label('payment_fee', trans('strings.payment_fee'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('payment_fee', null, ['class' => 'form-control', 'placeholder' => trans('strings.payment_fee')]) !!}
    </div>
</div><!--form control-->

        <div class="form-group">
            {!! Form::label('cart_recovery', trans('strings.cart_recovery'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('cart_recovery', number_format($configuration->cart_recovery, 2, ',', '.' ), ['class' => 'form-control', 'placeholder' => trans('strings.cart_recovery')]) !!}
            </div>
        </div><!--form control-->

        <div class="pull-right">
            <input type="submit" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
        </div>
        <div class="clearfix"></div>

    {!! Form::close() !!}
@stop