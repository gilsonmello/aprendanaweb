@extends ('backend.layouts.master')

@section ('title', trans('menus.faq_category_management') . ' | ' . trans('menus.create_faq_category'))

@section('page-header')
    <h1>
        {{ trans('menus.faq_category_management') }}
        <small>{{ trans('menus.create_faq_category') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li>{!! link_to_route('admin.faqcategory.index', trans('menus.faqcategory')) !!}</li>
    <li class="active">{!! link_to_route('admin.faqcategory.create', trans('menus.create_faq_category')) !!}</li>
@stop

@section('content')

    {!! Form::open(['route' => 'admin.faqcategory.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post']) !!}

        <div class="form-group">
            {!! Form::label('description', trans('validation.attributes.description'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('description', null, ['class' => 'form-control', 'placeholder' => trans('strings.description')]) !!}
            </div>
        </div>

        <!--form control-->

        <div class="pull-left">
            <a href="{{route('admin.faqcategory.index', ['page' => Session::get('lastpage', '1')])}}" class="btn btn-danger">{{ trans('strings.cancel_button') }}</a>
        </div>

        <div class="pull-right">
            <input type="submit" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
        </div>
        <div class="clearfix"></div>

    {!! Form::close() !!}
@stop