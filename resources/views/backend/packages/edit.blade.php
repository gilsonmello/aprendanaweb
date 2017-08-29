@extends ('backend.layouts.master')

@section ('title', trans('menus.package_management') . ' | ' . trans('menus.create_package'))

@section ('before-styles-end')
    {!! HTML::style('css/plugin/jquery.onoff.css') !!}
@stop

@section('page-header')
    <h1>
        {{ trans('menus.package_management') }}
        <small>{{ trans('menus.create_package') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li>{!! link_to_route('admin.packages.index', trans('menus.packages')) !!}</li>
    <li class="active">{!! link_to_route('admin.packages.create', trans('menus.create_package')) !!}</li>
@stop

@section('content')
    <div class="pull-right" style="margin-bottom:10px">
        <a href="{{route('admin.packageexams.index')}}?f_package_id={{$package->id}}" class="btn btn-primary btn-xs">{{ trans('menus.package_exams') }}</a>
    </div>
    <br/>
    <br/>

    {!! Form::model($package, ['route' => ['admin.packages.update', $package->id], 'class' => 'form-horizontal','id' => 'package-form', 'role' => 'form', 'method' => 'PATCH', 'files' => true]) !!}

        <div class="form-group">
            {!! Form::label('subsection_id', trans('validation.attributes.subsection'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::select('subsection_id', $subsections, $package->subsection_id, ['class' => 'form-control']) !!}
            </div><!-- /.col -->
        </div>

        <div class="form-group">
            {!! Form::label('title', trans('validation.attributes.title'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => trans('strings.title')]) !!}
            </div>
        </div><!--form control-->

        <div class="form-group">
            {!! Form::label('slug', trans('validation.attributes.slug'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('slug', null, ['class' => 'form-control', 'placeholder' => trans('strings.slug')]) !!}
            </div>
        </div><!--form control-->

        <div class="form-group">
            {!! Form::label('description', trans('validation.attributes.description'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                <div class="box-body" style="padding: 0px;">
                    {!! Form::textarea('description', null, ['class' => 'form-control textarea', 'placeholder' => trans('strings.description')]) !!}
                </div>
            </div>
        </div><!--form control-->

        <div class="form-group">
            {!! Form::label('short_description', trans('validation.attributes.short_description'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                <div class="box-body" style="padding: 0px;">
                    {!! Form::textarea('short_description', null, ['maxlength' => '140', 'class' => 'form-control', 'placeholder' => trans('strings.short_description')]) !!}
                </div>
            </div>
        </div><!--form control-->

        <div class="form-group">
            {!! Form::label('meta_title', "Meta Title", ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                <div class="box-body" style="padding: 0px;">
                    {!! Form::textarea('meta_title', null, ['maxlength' => '140', 'class' => 'form-control', 'placeholder' => "Meta Title"]) !!}
                </div>
            </div>
        </div><!--form control-->

        <div class="form-group">
            {!! Form::label('meta_description', "Meta Description", ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                <div class="box-body" style="padding: 0px;">
                    {!! Form::textarea('meta_description', null, ['maxlength' => '140', 'class' => 'form-control', 'placeholder' => "Meta Description"]) !!}
                </div>
            </div>
        </div><!--form control-->

        <div class="form-group">
            {!! Form::label('image', trans('validation.attributes.image'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                <input type="file" name="featured_img"/>
                <img height="100"  src="{{ imageurl('packages/',$package->id, $package->featured_img, 100, 'generic.png', true) }}">

            </div><!-- /.col -->
        </div>

    <div class="form-group">
            {!! Form::label('video', trans('validation.attributes.video'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('video_ad_url', null, ['class' => 'form-control', 'placeholder' => trans('strings.video')]) !!}
            </div>
        </div><!--form control-->

    <div class="form-group">
        {!! Form::label('price', trans('validation.attributes.price'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('price', number_format($package->price, 2, ',', '.' ) , ['class' => 'form-control money', 'placeholder' => trans('strings.price')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('discount_price', trans('validation.attributes.discount_price'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('discount_price', number_format($package->discount_price, 2, ',', '.' ), ['class' => 'form-control money', 'placeholder' => trans('strings.discount_price')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('teachers_percentage', trans('validation.attributes.teachers_percentage'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('teachers_percentage', number_format($package->teachers_percentage, 2, ',', '.' ), ['class' => 'form-control', 'placeholder' => trans('strings.teachers_percentage')]) !!}
        </div>
    </div><!--form control-->

    <div class="form-group">
        {!! Form::label('access_time', trans('validation.attributes.access_time'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('access_time', null, ['class' => 'form-control', 'placeholder' => trans('strings.access_time')]) !!}
        </div>
    </div><!--form control-->

    <hr/>
    <div class="form-group">
        {!! Form::label('start_special_price', trans('validation.attributes.start_special_price'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('start_special_price', null, ['class' => 'form-control datepicker datemask', 'placeholder' => trans('strings.start_special_price')]) !!}
        </div>
    </div><!--form control-->
    <div class="form-group">
        {!! Form::label('end_special_price', trans('validation.attributes.end_special_price'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('end_special_price', null, ['class' => 'form-control datepicker datemask', 'placeholder' => trans('strings.end_special_price')]) !!}
        </div>
    </div><!--form control-->
    <div class="form-group">
        {!! Form::label('special_price', trans('validation.attributes.special_price'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('special_price', number_format($package->special_price, 2, ',', '.' ), ['class' => 'form-control money', 'placeholder' => trans('strings.special_price')]) !!}
        </div>
    </div><!--form control-->
    <hr/>

    <div class="form-group">
        {!! Form::label('tags', trans('validation.attributes.tags'), ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::select('tags[]', $package->tags_array, $package->tags_array, ['class' => 'form-control tags-select', 'multiple' => 'multiple']) !!}
        </div>
    </div>


        <div class="form-group">
            {!! Form::label('activation_date', trans('validation.attributes.activation_date'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('activation_date', null, ['class' => 'form-control datemask datepicker ', 'placeholder' => trans('validation.attributes.activation_date')]) !!}
            </div>
        </div><!--form control-->

    <div class="form-group">
        <label class="col-lg-2 control-label">{{ trans('validation.attributes.active') }}</label>
        <div class="col-lg-1">
            <div class="sw-green create-permissions-switch">
                <div class="onoffswitch">
                    <input type="checkbox" value="1" name="is_active" class="toggleBtn onoffswitch-checkbox" id="package-active" @if($package->is_active == 1)checked="checked"@endif>
                    <label for="package-active" class="onoffswitch-label">
                        <div class="onoffswitch-inner"></div>
                        <div class="onoffswitch-switch"></div>
                    </label>
                </div>
            </div><!--green checkbox-->
        </div>
    </div><!--form control-->
    
    {{--<div class="form-group">--}}
        {{--<label class="col-lg-2 control-label">{{ trans('validation.attributes.featured') }}</label>--}}
        {{--<div class="col-lg-1">--}}
            {{--<div class="sw-green create-permissions-switch">--}}
                {{--<div class="onoffswitch">--}}
                    {{--<input type="checkbox" value="1" name="featured" class="toggleBtn onoffswitch-checkbox" id="package-active">--}}
                    {{--<label for="package-featured" class="onoffswitch-label">--}}
                        {{--<div class="onoffswitch-inner"></div>--}}
                        {{--<div class="onoffswitch-switch"></div>--}}
                    {{--</label>--}}
                {{--</div>--}}
            {{--</div><!--green checkbox-->--}}
        {{--</div>--}}
    {{--</div><!--form control-->--}}

    {{--<div class="form-group">--}}
        {{--<label class="col-lg-2 control-label">{{ trans('validation.attributes.special_offer') }}</label>--}}
        {{--<div class="col-lg-1">--}}
            {{--<div class="sw-green create-permissions-switch">--}}
                {{--<div class="onoffswitch">--}}
                    {{--<input type="checkbox" value="1" name="special_offer" class="toggleBtn onoffswitch-checkbox" id="package-special_offer">--}}
                    {{--<label for="package-special_offer" class="onoffswitch-label">--}}
                        {{--<div class="onoffswitch-inner"></div>--}}
                        {{--<div class="onoffswitch-switch"></div>--}}
                    {{--</label>--}}
                {{--</div>--}}
            {{--</div><!--green checkbox-->--}}
        {{--</div>--}}
    {{--</div><!--form control-->--}}


    <div class="pull-left">
        <a href="{{route('admin.packages.index')}}" class="btn btn-danger">{{ trans('strings.cancel_button') }}</a>
    </div>


    <div class="pull-right">
            <input type="submit" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
        </div>
        <div class="clearfix"></div>

    {!! Form::close() !!}
@stop