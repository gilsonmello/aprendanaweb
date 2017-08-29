@extends ('backend.layouts.master')

@section ('title', trans('menus.faqs'))

@section('page-header')
    <h1>
        {{ trans('menus.faqs') }}
        <small>{{ trans('menus.all_faqs') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.faqs.index', trans('menus.faqs')) !!}</li>
@stop

@section('content')

    <div class="pull-right" style="margin-bottom:10px">
        <a href="{{route('admin.faqs.create')}}" class="btn btn-primary btn-xs">
            {{ trans('menus.create_faq') }}
        </a>
    </div>

    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>{{ trans('crud.faqs.category') }}</th>
            <th>{{ trans('crud.faqs.question') }}</th>
            <th>{{ trans('crud.actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($faqs as $faq)
            <tr>
                <td>{!! $faq->faqcategory->description !!}</td>
                <td>{!! $faq->question !!}</td>
                <td>{!! $faq->action_buttons !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="pull-left">
        {!! $faqs->total() !!} {{ trans('crud.faqs.total') }}
    </div>

    <div class="pull-right">
        {!! $faqs->render() !!}
    </div>

    <div class="clearfix"></div>
@stop