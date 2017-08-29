@extends ('backend.layouts.master')

@section ('title', trans('menus.user_management') . ' | ' . trans('menus.create_user'))

@section('page-header')
    <h1>
        {{ trans('menus.news') }}
        <small>{{ trans('menus.edit_new') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li>{!! link_to_route('admin.news.index', trans('menus.news')) !!}</li>
    <li class="active">{!! link_to_route('admin.news.create', trans('menus.edit_new')) !!}</li>
@stop

@section('content')

    {!! Form::model($new, ['route' => ['admin.news.update', $new->id], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH', 'files' => true]) !!}

        <div class="form-group">
            {!! Form::label('title', trans('validation.attributes.title'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('title', null, ['class' => 'form-control title-has-slug', 'placeholder' => trans('strings.title')]) !!}
            </div>
        </div><!--form control-->

        <div class="form-group">
            {!! Form::label('slug', trans('validation.attributes.slug'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('slug', null, ['class' => 'form-control slug-from-title', 'placeholder' => trans('strings.slug')]) !!}
            </div>
        </div><!--form control-->

        <div class="form-group">
            {!! Form::label('date', trans('validation.attributes.date'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('date', null, ['class' => 'form-control datepicker', 'placeholder' => trans('strings.date')]) !!}
            </div>
        </div><!--form control-->

        <div class="form-group">
            {!! Form::label('content', trans('validation.attributes.content'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                <div class="box-body" style="padding: 0px;">
                    {!! Form::textarea('content', null, ['class' => 'form-control textarea', 'placeholder' => trans('strings.content')]) !!}
                </div>
            </div>
        </div><!--form control-->

        <div class="form-group">
            {!! Form::label('image', trans('validation.attributes.image'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! $new->img_html['square100'] !!}
                <input type="file" name="img"/>
            </div><!-- /.col -->
        </div>

        <div class="form-group">
            {!! Form::label('video', trans('validation.attributes.video'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('video', null, ['class' => 'form-control', 'placeholder' => trans('strings.video')]) !!}
            </div>
        </div><!--form control-->


        <div class="form-group">
            {!! Form::label('tags', trans('validation.attributes.tags'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::select('tags[]', $new->tags_array, $new->tags_array, ['class' => 'form-control tags-select', 'multiple' => 'multiple']) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('activation_date', trans('validation.attributes.activation_date'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('activation_date', null, ['class' => 'form-control datepicker', 'placeholder' => trans('validation.attributes.activation_date')]) !!}
            </div>
        </div><!--form control-->

    <div class="form-group">
        <label class="col-lg-2 control-label">{{ trans('validation.attributes.featured') }}</label>
        <div class="col-lg-1">
            <div class="sw-green create-permissions-switch">
                <div class="onoffswitch">
                    <input type="checkbox" value="1" name="featured" class="toggleBtn onoffswitch-checkbox" id="new-active" @if($new->featured == 1)checked="checked"@endif>
                    <label for="new-featured" class="onoffswitch-label">
                        <div class="onoffswitch-inner"></div>
                        <div class="onoffswitch-switch"></div>
                    </label>
                </div>
            </div><!--green checkbox-->
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('domains', trans('strings.domain'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::select("domains[]", [''=>'Não informado'] + $domains->lists("name","id")->all(), ( $new->domain()->get()->first() != null ? $new->domain()->get()->first()->id : null), ['class' => 'form-control select2', 'placeholder' => trans('strings.choice_domain') ])  !!}

        </div>
    </div>
    
    
        <div class="pull-left">
            <a href="{{route('admin.news.index', ['page' => Session::get('lastpage', '1')])}}" class="btn btn-danger">{{ trans('strings.cancel_button') }}</a>
        </div>

        <div class="pull-right">
            <input type="submit" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
        </div>
        <div class="clearfix"></div>

    {!! Form::close() !!}
@stop