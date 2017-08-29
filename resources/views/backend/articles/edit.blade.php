@extends ('backend.layouts.master')

@section ('title', trans('menus.user_management') . ' | ' . trans('menus.create_user'))

@section('page-header')
    <h1>
        {{ trans('menus.articles') }}
        <small>{{ trans('menus.edit_article') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li>{!! link_to_route('admin.articles.index', trans('menus.articles')) !!}</li>
    <li class="active">{!! link_to_route('admin.articles.create', trans('menus.edit_article')) !!}</li>
@stop

@section('content')

    {!! Form::model($article, ['route' => ['admin.articles.update', $article->id], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH', 'files' => true]) !!}

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
            {!! Form::label('teachers', trans('validation.attributes.teacher'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::select('teachers[]', $article->users->lists('name','id')->all(), $article->users->lists('id')->all(), ['class' => 'form-control users-select', 'multiple' => 'multiple']) !!}
            </div><!-- /.col -->
        </div>

        <div class="form-group">
            {!! Form::label('image', trans('validation.attributes.image'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! $article->img_html['square100'] !!}
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
                {!! Form::select('tags[]', $article->tags_array, $article->tags_array, ['class' => 'form-control tags-select', 'multiple' => 'multiple']) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('activation_date', trans('validation.attributes.activation_date'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('activation_date', null, ['class' => 'form-control datepicker', 'placeholder' => trans('validation.attributes.activation_date')]) !!}
            </div>
        </div><!--form control-->

        @if(access()->hasRole('Administrador'))
            <div class="form-group">
                <label class="col-lg-2 control-label">{{ trans('validation.attributes.active') }}</label>
                <div class="col-lg-1">
                    <div class="sw-green create-permissions-switch">
                        <div class="onoffswitch">
                            <input type="checkbox" value="1" name="status" class="toggleBtn onoffswitch-checkbox" id="article-active" @if($article->status == 1)checked="checked"@endif>
                            <label for="article-active" class="onoffswitch-label">
                                <div class="onoffswitch-inner"></div>
                                <div class="onoffswitch-switch"></div>
                            </label>
                        </div>
                    </div><!--green checkbox-->
                </div>
            </div><!--form control-->
        @endif


        <div class="pull-left">
            <a href="{{route('admin.articles.index', ['page' => Session::get('lastpage', '1')])}}" class="btn btn-danger">{{ trans('strings.cancel_button') }}</a>
        </div>

        <div class="pull-right">
            <input type="submit" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
        </div>
        <div class="clearfix"></div>

    {!! Form::close() !!}
@stop