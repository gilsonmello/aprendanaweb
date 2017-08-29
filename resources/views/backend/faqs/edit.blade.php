@extends ('backend.layouts.master')

@section ('title', trans('menus.user_management') . ' | ' . trans('menus.create_user'))

@section('page-header')
    <h1>
        {{ trans('menus.faqs') }}
        <small>{{ trans('menus.edit_faq') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li>{!! link_to_route('admin.faqs.index', trans('menus.faqs')) !!}</li>
    <li class="active">{!! link_to_route('admin.faqs.create', trans('menus.edit_faq')) !!}</li>
@stop

@section('content')

    {!! Form::model($faq, ['route' => ['admin.faqs.update', $faq->id], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH']) !!}

    <div class="form-group">
        {!! Form::label('faqcategorys', trans('validation.attributes.faqcategorys'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::select("faqcategorys[]",$faqcategorys->lists("description","id"), $faq->faqcategory()->get()->first()->id, ['class' => 'form-control select2', 'placeholder' => trans('strings.choice_faqs') ])  !!}

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