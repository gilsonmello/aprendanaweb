@extends ('backend.layouts.master')

@section ('title', trans('menus.products.product') . ' | ' . trans('menus.products.create'))

@section ('before-styles-end')
{!! HTML::style('css/plugin/jquery.onoff.css') !!}
@stop

@section('page-header')
<h1>
    {{ trans('menus.products.management') }}
    <small>{{ trans('menus.products.create') }}</small>
</h1>
@endsection

@section ('breadcrumbs')
<li>
    <a href="{!!route('backend.dashboard')!!}">
        <i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}
    </a>
</li>
<li>
    {!! link_to_route('admin.products.index', trans('menus.products.products')) !!}
</li>
<li class="active">
    {!! trans('strings.create_supplier') !!}
</li>
@stop

@section('content')

{!! Form::open(['route' => 'admin.products.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post', 'files' => true]) !!}

<div class="form-group">
    {!! Form::label('suppliers_id',  trans('validation.attributes.supplier'), ['class' => 'col-md-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::select('supplier_id', $suppliers->lists('company_name', 'id')->all(), null, ['class' => 'select2']) !!}
    </div>
</div><!--form control-->

<div class="form-group">
    {!! Form::label('type',  trans('validation.attributes.type'), ['class' => 'col-md-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::select('type', ['id' => 'Livro'], null, ['class' => 'select2']) !!}
    </div>
</div><!--form control-->

<div class="form-group">
    {!! Form::label('title', trans('validation.attributes.title'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => trans('strings.title')]) !!}
    </div>
</div><!--form control-->

<div class="form-group">
    {!! Form::label('tags', trans('validation.attributes.tags'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::select('tags[]', [], null, ['class' => 'form-control tags-select', 'multiple' => 'multiple']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('description', trans('validation.attributes.description'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        <div class="box-body" style="padding: 0px;">
            {!! Form::textarea('description', null, ['class' => 'form-control textarea', 'placeholder' => trans('strings.description')]) !!}
        </div>
    </div>
</div><!--form control-->

<div class="form-group">
    {!! Form::label('commission', trans('validation.attributes.commission'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('commission', null, ['class' => 'form-control money', 'placeholder' => trans('strings.commission')]) !!}
    </div>
</div><!--form control-->

<div class="form-group">
{!! Form::label('shipping_free',  trans('validation.attributes.shipping_free').'?', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-lg-3">
         {!!  Form::checkbox('shipping_free')  !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('price', trans('validation.attributes.price'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('price', null, ['class' => 'form-control money', 'placeholder' => trans('strings.price')]) !!}
    </div>
</div><!--form control-->

<div class="form-group">
    {!! Form::label('discount_price', trans('validation.attributes.discount_price'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('discount_price', null, ['class' => 'form-control money', 'placeholder' => trans('strings.discount_price')]) !!}
    </div>
</div><!--form control-->

<div class="form-group">
{!! Form::label('is_active',  trans('validation.attributes.is_active').'?', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-lg-3">
         {!!  Form::checkbox('is_active')  !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('subject', trans('validation.attributes.subject'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('subject', null, ['class' => 'form-control', 'placeholder' => trans('strings.subject')]) !!}
    </div>
</div><!--form control-->

<div class="form-group">
    {!! Form::label('author_id',  trans('validation.attributes.teacher').'?', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::select('author_id', $suppliers->lists('company_name', 'id')->all(), null, ['class' => 'select2']) !!}
    </div>
</div><!--form control-->

<div class="form-group">
    {!! Form::label('author_name', trans('validation.attributes.author_name'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('author_name', null, ['class' => 'form-control', 'placeholder' => trans('strings.author_name')]) !!}
    </div>
</div><!--form control-->

<div class="form-group">
    {!! Form::label('pages', trans('validation.attributes.pages'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('pages', null, ['class' => 'form-control', 'placeholder' => trans('strings.pages')]) !!}
    </div>
</div><!--form control-->

<div class="form-group">
    {!! Form::label('isbn', trans('validation.attributes.isbn'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('isbn', null, ['class' => 'form-control', 'placeholder' => trans('strings.isbn')]) !!}
    </div>
</div><!--form control-->

<div class="form-group">
    {!! Form::label('slug', trans('validation.attributes.slug'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('slug', null, ['class' => 'form-control', 'placeholder' => trans('strings.slug')]) !!}
    </div>
</div><!--form control-->

<div class="form-group">
    {!! Form::label('dimensions', trans('validation.attributes.dimensions'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('dimensions', null, ['class' => 'form-control', 'placeholder' => trans('strings.dimensions')]) !!}
    </div>
</div><!--form control-->

<div class="form-group">
    {!! Form::label('edition', trans('validation.attributes.edition'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('edition', null, ['class' => 'form-control', 'placeholder' => trans('strings.edition')]) !!}
    </div>
</div><!--form control-->

<div class="form-group">
    {!! Form::label('release', trans('validation.attributes.release'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('release', null, ['class' => 'form-control datemask', 'placeholder' => trans('strings.release')]) !!}
    </div>
</div><!--form control-->

<div class="form-group">
    {!! Form::label('stuff', trans('validation.attributes.stuff'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('stuff', null, ['class' => 'form-control', 'placeholder' => trans('strings.stuff')]) !!}
    </div>
</div><!--form control-->

<div class="form-group">
    {!! Form::label(null, '&nbsp;', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        <div class="pull-left">
            <a href="{{route('admin.products.index', ['page' => Session::get('lastpage', '1')])}}" class="btn btn-danger">{{ trans('strings.cancel_button') }}</a>
        </div>
        <div class="pull-right">
            <input type="submit" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
        </div>
    </div>
</div>

<div class="clearfix"></div>

{!! Form::close() !!}
@stop