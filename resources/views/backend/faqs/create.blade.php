@extends ('backend.layouts.master')

@section ('title', trans('menus.faq_management') . ' | ' . trans('menus.create_faq'))

@section('page-header')
    <h1>
        {{ trans('menus.faq_management') }}
        <small>{{ trans('menus.create_faq') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li>{!! link_to_route('admin.faqs.index', trans('menus.faqs')) !!}</li>
    <li class="active">{!! link_to_route('admin.faqs.create', trans('menus.create_faq')) !!}</li>
@stop

@section('content')

    {!! Form::open(['route' => 'admin.faqs.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post']) !!}

        <div class="form-group">
            {!! Form::label('faqcategorys', trans('validation.attributes.faqcategorys'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::select("faqcategorys[]",$faqcategorys->lists("description","id"), null, ['class' => 'form-control select2', 'placeholder' => trans('strings.choice_faqs') ])  !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('question', trans('validation.attributes.question'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('question', null, ['class' => 'form-control', 'placeholder' => trans('strings.question')]) !!}
            </div>
        </div><!--form control-->

        <div class="form-group">
            {!! Form::label('answer', trans('validation.attributes.answer'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::textarea('answer', null, ['class' => 'form-control', 'placeholder' => trans('strings.answer')]) !!}
            </div>
        </div><!--form control-->

        <div class="pull-left">
            <a href="{{route('admin.faqs.index', ['page' => Session::get('lastpage', '1')])}}" class="btn btn-danger">{{ trans('strings.cancel_button') }}</a>
        </div>

        <div class="pull-right">
            <input type="submit" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
        </div>
        <div class="clearfix"></div>

    {!! Form::close() !!}
@stop