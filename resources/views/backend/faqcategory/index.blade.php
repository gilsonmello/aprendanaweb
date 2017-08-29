@extends ('backend.layouts.master')

@section ('title', trans('menus.faq_category'))

@section('page-header')
    <h1>
        {{ trans('menus.faq_category') }}
        <small>{{ trans('menus.all_faq_category') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.faqcategory.index', trans('menus.faq_category')) !!}</li>
@stop

@section('content')

    <div class="pull-right" style="margin-bottom:10px">
        <a href="{{route('admin.faqcategory.create')}}" class="btn btn-primary btn-xs">
            {{ trans('menus.create_faq_category') }}
        </a>
    </div>

    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>{{ trans('crud.faqcategory.description') }}</th>
            <th width="100">{{ trans('crud.actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($faqcategories as $faqcategory)
            <tr>
                <td>{!! $faqcategory->description !!}</td>
                <td>{!! $faqcategory->action_buttons !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="pull-left">
        {!! $faqcategories->total() !!} {{ trans('crud.faqcategory.total') }}
    </div>

    <div class="pull-right">
        {!! $faqcategories->render() !!}
    </div>

    <div class="clearfix"></div>
@stop