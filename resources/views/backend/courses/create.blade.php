@extends ('backend.layouts.master')

@section ('title', trans('menus.course_management') . ' | ' . trans('menus.create_course'))

@section ('before-styles-end')
{!! HTML::style('css/plugin/jquery.onoff.css') !!}
@stop

@section('page-header')
<h1>
    {{ trans('menus.course_management') }}
    <small>{{ trans('menus.create_course') }}</small>
</h1>
@endsection

@section ('breadcrumbs')
<li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
<li>{!! link_to_route('admin.courses.index', trans('menus.courses')) !!}</li>
<li class="active">{!! link_to_route('admin.courses.create', trans('menus.create_course')) !!}</li>
@stop

@section('content')

{!! Form::open(['route' => 'admin.courses.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post', 'files' => true]) !!}

<div class="form-group">
    {!! Form::label('teachers', trans('strings.cordinators'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::select('teachers[]', $teachers->lists('name', 'id')->all() , null , ['class' => 'form-control select2', 'multiple' => 'multiple']) !!}
    </div><!-- /.col -->
</div>

<div class="form-group">
    {!! Form::label('subsection_id', trans('validation.attributes.subsection'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::select('subsection_id', $subsections, null, ['class' => 'form-control']) !!}
    </div><!-- /.col -->
</div>

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
    {!! Form::label('course_content', trans('validation.attributes.course_content'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        <div class="box-body" style="padding: 0px;">
            {!! Form::textarea('course_content', null, ['class' => 'form-control textarea', 'placeholder' => trans('strings.course_content')]) !!}
        </div>
    </div>
</div><!--form control-->

<div class="form-group">
    {!! Form::label('methodology', trans('validation.attributes.methodology'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        <div class="box-body" style="padding: 0px;">
            {!! Form::textarea('methodology', null, ['class' => 'form-control textarea', 'placeholder' => trans('strings.methodology')]) !!}
        </div>
    </div>
</div><!--form control-->


<div class="form-group">
    {!! Form::label('testimonials', trans('strings.testimonials'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        <div class="box-body" style="padding: 0px;">
            {!! Form::textarea('testimonials', null, ['class' => 'form-control textarea', 'placeholder' => trans('strings.testimonials')]) !!}
        </div>
    </div>
</div><!--form control-->

<div class="form-group">
    {!! Form::label('welcome_message', trans('strings.welcome_message'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        <div class="box-body" style="padding: 0px;">
            {!! Form::textarea('welcome_message', null, ['class' => 'form-control textarea', 'placeholder' => trans('strings.welcome_message')]) !!}
        </div>
    </div>
</div><!--form control-->

<div class="form-group">
    {!! Form::label('certification', trans('strings.certification'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        <div class="box-body" style="padding: 0px;">
            {!! Form::textarea('certification', null, ['class' => 'form-control textarea', 'placeholder' => trans('strings.certification')]) !!}
        </div>
    </div>
</div><!--form control-->

<div class="form-group">
    {!! Form::label('certification_template', trans('validation.attributes.certification_template'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-8">
        {!! Form::text('certification_template', null, ['class' => 'form-control', 'placeholder' => trans('strings.certification_template')]) !!}
    </div>
    <div class="col-lg-2">
        {!! Form::label('certification_template', "Ex.: arquivo.pdf",  ['class' => 'control-label']) !!}
    </div>
</div><!--form control-->

{{-- Público Alvo --}}
<div class="form-group">
    {!! Form::label('target_public', trans('strings.target_public'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        <div class="box-body" style="padding: 0px;">
            {!! Form::textarea('target_public', null, ['class' => 'form-control', 'placeholder' => trans('strings.target_public')]) !!}
        </div>
    </div>
</div><!--form control-->

{{-- Link aula demonstrativa --}}
<div class="form-group">
    {!! Form::label('demonstrative_lesson', trans('strings.demonstrative_lesson'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('demonstrative_lesson', null, ['class' => 'form-control', 'placeholder' => trans('strings.demonstrative_lesson')]) !!}
    </div>
</div><!--form control-->

{{-- Link Edital --}}
<div class="form-group">
    {!! Form::label('notice', trans('strings.notice'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('notice', null, ['class' => 'form-control', 'placeholder' => trans('strings.notice')]) !!}
    </div>
</div><!--form control-->

{{-- Público Alvo --}}
<div class="form-group">
    {!! Form::label('differentials', trans('strings.differentials'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        <div class="box-body" style="padding: 0px;">
            {!! Form::textarea('differentials', null, ['class' => 'form-control', 'placeholder' => trans('strings.differentials')]) !!}
        </div>
    </div>
</div><!--form control-->

<div class="form-group">
    {!! Form::label('meta_title', "Meta Title", ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        <div class="box-body" style="padding: 0px;">
            {!! Form::textarea('meta_title', null, ['class' => 'form-control', 'placeholder' => "Meta Title"]) !!}
        </div>
    </div>
</div><!--form control-->

<div class="form-group">
    {!! Form::label('meta_description', "Meta Description", ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        <div class="box-body" style="padding: 0px;">
            {!! Form::textarea('meta_description', null, ['class' => 'form-control', 'placeholder' => "Meta Description"]) !!}
        </div>
    </div>
</div><!--form control-->

<div class="form-group">
    {!! Form::label('image', trans('validation.attributes.image'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        <input type="file" name="featured_img"/>
    </div><!-- /.col -->
</div>

<div class="form-group">
    {!! Form::label('image', trans('validation.attributes.classroom_image'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        <input type="file" name="classroom_img"/>
    </div><!-- /.col -->
</div>


<div class="form-group">
    {!! Form::label('video', trans('validation.attributes.video'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('video_ad_url', null, ['class' => 'form-control', 'placeholder' => trans('strings.video')]) !!}
    </div>
</div><!--form control-->

<div class="form-group">
    {!! Form::label('analysis', trans('strings.analysis'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('analysis', null, ['class' => 'form-control', 'placeholder' => trans('strings.analysis')]) !!}
    </div>
</div><!--form control-->

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
    {!! Form::label('payment', trans('validation.attributes.payment'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('payment', null, ['class' => 'form-control', 'placeholder' => trans('strings.payment')]) !!}
    </div>
</div><!--form control-->


<div class="form-group">
    {!! Form::label('teachers_percentage', trans('validation.attributes.teachers_percentage'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('teachers_percentage', $configuration->percetage_share_teachers, ['class' => 'form-control', 'placeholder' => trans('strings.teachers_percentage')]) !!}
    </div>
</div><!--form control-->

<div class="form-group">
    {!! Form::label('access_time', trans('validation.attributes.access_time'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('access_time', null, ['class' => 'form-control', 'placeholder' => trans('strings.access_time')]) !!}
    </div>
</div><!--form control-->


<div class="form-group">
    {!! Form::label('workload', trans('validation.attributes.workload'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('workload', null, ['class' => 'form-control time', 'placeholder' => trans('strings.workload')]) !!}
    </div>
</div><!--form control-->


<div class="form-group">
    {!! Form::label('workload_presential', trans('validation.attributes.workload_presential'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('workload_presential', null, ['class' => 'form-control time', 'placeholder' => trans('strings.workload_presential')]) !!}
    </div>
</div><!--form control-->

<div class="form-group">
    {!! Form::label('time_per_content', trans('strings.time_per_content'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('time_per_content', null , ['class' => 'form-control', 'placeholder' => trans('strings.time_per_content')]) !!}
    </div>
</div><!--form control-->


<div class="form-group">
    {!! Form::label('max_view', trans('validation.attributes.max_view'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('max_view', $configuration->video_views, ['class' => 'form-control', 'placeholder' => trans('strings.max_view')]) !!}
    </div>
</div><!--form control-->

<div class="form-group">
    {!! Form::label('percentage_certificate', trans('strings.percentage_certificate'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('percentage_certificate', $configuration->percentage_certificate, ['class' => 'form-control', 'placeholder' => trans('strings.percentage_certificate')]) !!}
    </div>
</div><!--form control-->

<div class="form-group">
    {!! Form::label('minimum_percentage', trans('strings.minimum_percentage'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('minimum_percentage', null, ['class' => 'form-control', 'placeholder' => trans('strings.minimum_percentage')]) !!}
    </div>
</div><!--form control-->
</hr>
<div class="form-group">
    {!! Form::label('custom_workshop_title', trans('validation.attributes.custom_workshop_title'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('custom_workshop_title', null, ['class' => 'form-control', 'placeholder' => trans('strings.custom_workshop_title')]) !!}
    </div>
</div><!--form control-->
</hr>

<div class="form-group">
    <label class="col-lg-2 control-label">{{ trans('validation.attributes.certification_individual_auth') }}</label>
    <div class="col-lg-1">
        <div class="sw-green create-permissions-switch">
            <div class="onoffswitch">
                <input type="checkbox" value="1" name="certification_individual_auth" class="toggleBtn onoffswitch-checkbox" id="course-certification_individual_auth"  >
                <label for="course-certification_individual_auth" class="onoffswitch-label">
                    <div class="onoffswitch-inner"></div>
                    <div class="onoffswitch-switch"></div>
                </label>
            </div>
        </div><!--green checkbox-->
    </div>
</div><!--form control-->
<div class="form-group">
    {!! Form::label('activation_date', trans('validation.attributes.certification_individual_text'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('certification_individual_text', null, ['class' => 'form-control', 'placeholder' => trans('strings.certification_individual_text')]) !!}
    </div><!--green checkbox-->
</div><!--form control-->

<div class="form-group">
    {!! Form::label('tags', trans('validation.attributes.tags'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::select('tags[]', [], [], ['class' => 'form-control tags-select', 'multiple' => 'multiple']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('activation_date', trans('validation.attributes.activation_date'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('activation_date', null, ['class' => 'form-control datemask datepicker', 'placeholder' => trans('validation.attributes.activation_date')]) !!}
    </div>
</div><!--form control-->


<div class="form-group">
    {!! Form::label('beginOfCourse', trans('validation.attributes.beginOfCourse'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::text('beginOfCourse', null, ['class' => 'form-control', 'placeholder' => trans('strings.beginOfCourse')]) !!}
    </div>
</div>

<div class="form-group">
    <label class="col-lg-2 control-label">{{ trans('validation.attributes.featured') }}</label>
    <div class="col-lg-1">
        <div class="sw-green create-permissions-switch">
            <div class="onoffswitch">
                <input type="checkbox" value="1" name="featured" class="toggleBtn onoffswitch-checkbox" id="course-featured">
                <label for="course-featured" class="onoffswitch-label">
                    <div class="onoffswitch-inner"></div>
                    <div class="onoffswitch-switch"></div>
                </label>
            </div>
        </div><!--green checkbox-->
    </div>
</div><!--form control-->

<div class="form-group">
    <label class="col-lg-2 control-label">{{ trans('validation.attributes.special_offer') }}</label>
    <div class="col-lg-1">
        <div class="sw-green create-permissions-switch">
            <div class="onoffswitch">
                <input type="checkbox" value="1" name="special_offer" class="toggleBtn onoffswitch-checkbox" id="course-special_offer">
                <label for="course-special_offer" class="onoffswitch-label">
                    <div class="onoffswitch-inner"></div>
                    <div class="onoffswitch-switch"></div>
                </label>
            </div>
        </div><!--green checkbox-->
    </div>
</div><!--form control-->

<div class="form-group">
    <label class="col-lg-2 control-label">{{ trans('validation.attributes.show_files') }}</label>
    <div class="col-lg-1">
        <div class="sw-green create-permissions-switch">
            <div class="onoffswitch">
                <input type="checkbox" value="1" name="show_files" class="toggleBtn onoffswitch-checkbox" id="course-show_files" checked="checked">
                <label for="course-show_files" class="onoffswitch-label">
                    <div class="onoffswitch-inner"></div>
                    <div class="onoffswitch-switch"></div>
                </label>
            </div>
        </div><!--green checkbox-->
    </div>
</div><!--form control-->

<div class="form-group">
    <label class="col-lg-2 control-label">{{ trans('validation.attributes.show_calendar') }}</label>
    <div class="col-lg-1">
        <div class="sw-green create-permissions-switch">
            <div class="onoffswitch">
                <input type="checkbox" value="1" name="show_calendar" class="toggleBtn onoffswitch-checkbox" id="course-show_calendar" checked="checked">
                <label for="course-show_calendar" class="onoffswitch-label">
                    <div class="onoffswitch-inner"></div>
                    <div class="onoffswitch-switch"></div>
                </label>
            </div>
        </div><!--green checkbox-->
    </div>
</div><!--form control-->

<div class="form-group">
    <label class="col-lg-2 control-label">{{ trans('validation.attributes.show_alert') }}</label>
    <div class="col-lg-1">
        <div class="sw-green create-permissions-switch">
            <div class="onoffswitch">
                <input type="checkbox" value="1" name="show_alert" class="toggleBtn onoffswitch-checkbox" id="course-show_alert" checked="checked">
                <label for="course-show_alert" class="onoffswitch-label">
                    <div class="onoffswitch-inner"></div>
                    <div class="onoffswitch-switch"></div>
                </label>
            </div>
        </div><!--green checkbox-->
    </div>
</div><!--form control-->

<div class="form-group">
    <label class="col-lg-2 control-label">{{ trans('validation.attributes.generate_certificate') }}</label>
    <div class="col-lg-1">
        <div class="sw-green create-permissions-switch">
            <div class="onoffswitch">
                <input type="checkbox" value="1" name="generate_certificate" class="toggleBtn onoffswitch-checkbox" id="course-generate_certificate" checked="checked">
                <label for="course-generate_certificate" class="onoffswitch-label">
                    <div class="onoffswitch-inner"></div>
                    <div class="onoffswitch-switch"></div>
                </label>
            </div>
        </div><!--green checkbox-->
    </div>
</div><!--form control-->

<div class="form-group">
    <label class="col-lg-2 control-label">{{ trans('validation.attributes.online_for_presential') }}</label>
    <div class="col-lg-1">
        <div class="sw-green create-permissions-switch">
            <div class="onoffswitch">
                <input type="checkbox" value="1" name="online_for_presential" class="toggleBtn onoffswitch-checkbox" id="course-online_for_presential" checked="checked">
                <label for="course-online_for_presential" class="onoffswitch-label">
                    <div class="onoffswitch-inner"></div>
                    <div class="onoffswitch-switch"></div>
                </label>
            </div>
        </div><!--green checkbox-->
    </div>
</div><!--form control-->

<div class="form-group">
    <label class="col-lg-2 control-label">{{--{{ trans('validation.attributes.active') }}--}}Liberar acesso ao tirar dúvidas</label>
    <div class="col-lg-1">
        <div class="sw-green create-permissions-switch">
            <div class="onoffswitch">
                <input type="checkbox" value="1" name="ask_the_teacher" class="toggleBtn onoffswitch-checkbox" id="course-active">
                <label for="course-active" class="onoffswitch-label">
                    <div class="onoffswitch-inner"></div>
                    <div class="onoffswitch-switch"></div>
                </label>
            </div>
        </div><!--green checkbox-->
    </div>
</div><!--form control-->

<div class="form-group">
    <label class="col-lg-2 control-label">{{ trans('validation.attributes.combo') }}</label>
    <div class="col-lg-1">
        <div class="sw-green create-permissions-switch">
            <div class="onoffswitch">
                <input type="checkbox" value="1" name="combo" class="toggleBtn onoffswitch-checkbox" id="course-combo" checked="checked">
                <label for="course-combo" class="onoffswitch-label">
                    <div class="onoffswitch-inner"></div>
                    <div class="onoffswitch-switch"></div>
                </label>
            </div>
        </div><!--green checkbox-->
    </div>
</div><!--form control-->


<div class="form-group">
    <label class="col-lg-2 control-label">{{ trans('validation.attributes.active') }}</label>
    <div class="col-lg-1">
        <div class="sw-green create-permissions-switch">
            <div class="onoffswitch">
                <input type="checkbox" value="1" name="is_active" class="toggleBtn onoffswitch-checkbox" id="course-active" checked="checked">
                <label for="course-active" class="onoffswitch-label">
                    <div class="onoffswitch-inner"></div>
                    <div class="onoffswitch-switch"></div>
                </label>
            </div>
        </div><!--green checkbox-->
    </div>
</div><!--form control-->



<div class="pull-left">
    <a href="{{route('admin.courses.index')}}" class="btn btn-danger">{{ trans('strings.cancel_button') }}</a>
</div>

<div class="pull-right">
    <input type="submit" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
</div>
<div class="clearfix"></div>

{!! Form::close() !!}
@stop