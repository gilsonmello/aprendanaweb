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

<div id="dynamic-flash">
</div>
<div class=".nav-tabs-custom" >
    <ul class="nav nav-tabs" style="margin-bottom:30px;">
        <li class="active">
            <a data-toggle="tab" href="#course" aria-expanded="true">{{trans('menus.course') }}</a>
        </li>
        <li>
            <a data-toggle="tab" href="#course-questions" aria-expanded="true">{{ trans('menus.course-questions') }}</a>
        </li>
        <li>
            <a data-toggle="tab" href="#course-teachers" aria-expanded="true">{{trans('menus.course-teachers') }}</a>
        </li>
        <li>
            <a data-toggle="tab" href="#course-materials" aria-expanded="true">{{trans('menus.course-materials') }}</a>
        </li>
        <li id="" class="">
            <a id="module-tab" data-toggle="tab" href="#modules" aria-expanded="true">{{trans('menus.modules') }}</a>
        </li>
        <li id="aggregate-saap_li" class="event_aggregate-saap" course-id="{{ $course->id }}">
            <a id="module-tab" data-toggle="tab"  href="#aggregate-saap" aria-expanded="true">{{trans('menus.saaps') }}</a>
        </li>
        <li id="" class="disabled">
            <a id="lessons-tab"  aria-expanded="true">{{ trans('menus.lessons') }}</a>
        </li>
    </ul>

    <div class="tab-content">
        <div id="course"  class="tab-pane active">
            <input type="hidden" id="course_id" name="course_id" value="{{ $course->id }}">
            {!! Form::model($course, ['route' => ['admin.courses.update', $course->id], 'class' => 'form-horizontal','id' => 'course-form', 'role' => 'form', 'method' => 'PATCH', 'files' => true]) !!}

            <div class="form-group">
                {!! Form::label('teachers', trans('strings.cordinators'), ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::select('teachers[]', $teachers->lists('name', 'id')->all(), $course->coordinators->lists('id')->all(), ['class' => 'form-control select2', 'multiple' => 'multiple']) !!}
                </div><!-- /.col -->
            </div>

            <div class="form-group">
                {!! Form::label('subsection_id', trans('validation.attributes.subsection'), ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::select('subsection_id', $subsections, $course->subsection_id, ['class' => 'form-control']) !!}
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
                    <input type="file" name="featured_img"/><br/>
                    <img height="100"  src="{{ imageurl('courses/',$course->id, $course->featured_img, 100, 'generic.png', true) }}">

                </div><!-- /.col -->
            </div>

            <div class="form-group">
                {!! Form::label('image', trans('validation.attributes.classroom_image'), ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    <input type="file" name="classroom_img"/><br/>
                    <img height="100"  src="{{ imageurl('courses/',$course->id, $course->classroom_img, 100, 'generic.png', true) }}">

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
                    {!! Form::text('price', number_format($course->price, 2, ',', '.' ) , ['class' => 'form-control money', 'placeholder' => trans('strings.price')]) !!}
                </div>
            </div><!--form control-->

            <div class="form-group">
                {!! Form::label('payment', trans('validation.attributes.payment'), ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::text('payment', null , ['class' => 'form-control', 'placeholder' => trans('strings.payment')]) !!}
                </div>
            </div><!--form control-->

            <div class="form-group">
                {!! Form::label('discount_price', trans('validation.attributes.discount_price'), ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::text('discount_price', number_format($course->discount_price, 2, ',', '.' ), ['class' => 'form-control money', 'placeholder' => trans('strings.discount_price')]) !!}
                </div>
            </div><!--form control-->
            <div class="form-group">
                {!! Form::label('max_installments', trans('validation.attributes.max_installments'), ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::text('max_installments', $course->max_installments, ['class' => 'form-control', 'placeholder' => trans('strings.max_installments')]) !!}
                </div>
            </div><!--form control-->



            <div class="form-group">
                {!! Form::label('teachers_percentage', trans('validation.attributes.teachers_percentage'), ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::text('teachers_percentage', number_format($course->teachers_percentage, 2, ',', '.' ), ['class' => 'form-control', 'placeholder' => trans('strings.teachers_percentage')]) !!}
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
                    {!! Form::text('workload', str_replace('.',',',$course->workload), ['class' => 'form-control', 'placeholder' => trans('strings.workload')]) !!}
                </div>
            </div><!--form control-->



            <div class="form-group">
                {!! Form::label('workload_presential', trans('validation.attributes.workload_presential'), ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::text('workload_presential', str_replace('.',',',$course->workload_presential), ['class' => 'form-control', 'placeholder' => trans('strings.workload_presential')]) !!}
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
                    {!! Form::text('max_view', null, ['class' => 'form-control', 'placeholder' => trans('strings.max_view')]) !!}
                </div>
            </div><!--form control-->

            <div class="form-group">
                {!! Form::label('percentage_certificate', trans('strings.percentage_certificate'), ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::text('percentage_certificate', null, ['class' => 'form-control', 'placeholder' => trans('strings.percentage_certificate')]) !!}
                </div>
            </div><!--form control-->

            <div class="form-group">
                {!! Form::label('minimum_percentage', trans('strings.minimum_percentage'), ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::text('minimum_percentage', null, ['class' => 'form-control', 'placeholder' => trans('strings.minimum_percentage')]) !!}
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
                    {!! Form::text('special_price', number_format($course->special_price, 2, ',', '.' ), ['class' => 'form-control money', 'placeholder' => trans('strings.special_price')]) !!}
                </div>
            </div><!--form control-->
            <hr/>
            <div class="form-group">
                {!! Form::label('custom_workshop_title', trans('validation.attributes.custom_workshop_title'), ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::text('custom_workshop_title', $course->custom_workshop_title, ['class' => 'form-control', 'placeholder' => trans('strings.custom_workshop_title')]) !!}
                </div>
            </div><!--form control-->

            <div class="form-group">
                <label class="col-lg-2 control-label">{{ trans('validation.attributes.certification_individual_auth') }}</label>
                <div class="col-lg-1">
                    <div class="sw-green create-permissions-switch">
                        <div class="onoffswitch">
                            <input type="checkbox" value="1" name="certification_individual_auth" class="toggleBtn onoffswitch-checkbox" id="course-certification_individual_auth"  @if($course->certification_individual_auth == 1)checked="checked"@endif>
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
                    {!! Form::text('certification_individual_text', $course->certification_individual_text, ['class' => 'form-control', 'placeholder' => trans('strings.certification_individual_text')]) !!}
                </div><!--green checkbox-->
            </div><!--form control-->

            </hr>

            <div class="form-group">
                {!! Form::label('tags', trans('validation.attributes.tags'), ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::select('tags[]', $course->tags_array, $course->tags_array, ['class' => 'form-control tags-select', 'multiple' => 'multiple']) !!}
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
                            <input type="checkbox" value="1" name="featured" class="toggleBtn onoffswitch-checkbox" id="course-featured" @if($course->featured == 1)checked="checked"@endif>
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
                            <input type="checkbox" value="1" name="special_offer" class="toggleBtn onoffswitch-checkbox" id="course-special_offer" @if($course->special_offer == 1)checked="checked"@endif>
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
                            <input type="checkbox" value="1" name="show_files" class="toggleBtn onoffswitch-checkbox" id="course-show_files"  @if($course->show_files == 1)checked="checked"@endif>
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
                            <input type="checkbox" value="1" name="show_calendar" class="toggleBtn onoffswitch-checkbox" id="course-show_calendar"   @if($course->show_calendar == 1)checked="checked"@endif>
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
                            <input type="checkbox" value="1" name="show_alert" class="toggleBtn onoffswitch-checkbox" id="course-show_alert"   @if($course->show_alert == 1)checked="checked"@endif>
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
                            <input type="checkbox" value="1" name="generate_certificate" class="toggleBtn onoffswitch-checkbox" id="course-generate_certificate"   @if($course->generate_certificate == 1)checked="checked"@endif>
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
                            <input type="checkbox" value="1" name="online_for_presential" class="toggleBtn onoffswitch-checkbox" id="course-online_for_presential"   @if($course->online_for_presential == 1)checked="checked"@endif>
                                   <label for="course-online_for_presential" class="onoffswitch-label">
                                <div class="onoffswitch-inner"></div>
                                <div class="onoffswitch-switch"></div>
                            </label>
                        </div>
                    </div><!--green checkbox-->
                </div>
            </div><!--form control-->

            <div class="form-group">
                <label class="col-lg-2 control-label">{{--{{ trans('validation.attributes.active') }}--}}Liberar acesso ao Tira Dúvidas</label>
                <div class="col-lg-1">
                    <div class="sw-green create-permissions-switch">
                        <div class="onoffswitch">
                            <input type="checkbox" value="1" name="ask_the_teacher" class="toggleBtn onoffswitch-checkbox" id="course-ask_the_teacher" @if($course->ask_the_teacher == 1)checked="checked"@endif>
                                   <label for="course-ask_the_teacher" class="onoffswitch-label">
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
                            <input type="checkbox" value="1" name="combo" class="toggleBtn onoffswitch-checkbox" id="course-combo" @if($course->combo == 1)checked="checked"@endif>
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
                            <input type="checkbox" value="1" name="is_active" class="toggleBtn onoffswitch-checkbox" id="course-active" @if($course->is_active == 1)checked="checked"@endif>
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


                <div style="display: inline-block">
                    <input type="button" id="unblock-course" class="btn btn-success" value="{{ trans('strings.validate_course') }}" />
                </div>
                &nbsp;&nbsp;&nbsp;
                <div class="pull-right"  style="display: inline-block">
                    <input type="submit" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
                </div>
            </div>

            <div class="clearfix"></div>

            {!! Form::close() !!}

        </div>

        <div id="course-teachers" class="tab-pane">
            @include('backend.courses.course-teachers')
        </div>

        <div id="course-materials" class="tab-pane">
            @include('backend.courses.course-materials')
        </div>

        <div id="modules" class="tab-pane">

            <table id="module-table" class="table table-bordered table-hover dataTable" role="grid">


                <thead>
                    <tr role="row">
                        <th aria-label="Id" aria-controls="id" tabindex="0">Id</th>
                        <th aria-label="Nome" aria-sort="ascending"  aria-controls="nome" tabindex="0" class="sorting_asc">Nome</th>
                        <th aria-label="Detalhes"  aria-controls="detalhes" tabindex="0" class="sorting">Detalhes</th>
                        <th aria-label="Aulas"  aria-controls="aulas" tabindex="0" class="sorting">Aulas</th>
                        <th aria-label="Excluir"  aria-controls="excluir" tabindex="0" class="sorting">Excluir</th>
                    </tr>
                </thead>




            </table>


            <div id="fields">


                <div class="box box-primary" style="margin-top:30px;">
                    <div class="box-header with-border">
                        <h3 class="box-title">Adicionar Disciplina</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    {!! Form::open(['route' => 'admin.modules.store', 'class' => 'form-horizontal','id' => 'module-id', 'role' => 'form', 'method' => 'post', 'files' => true]) !!}
                    <div class="box-body">
                        <div class="row">
                            @for( $i = 0; $i < 1; $i++)
                            <div class="form-group">

                                {!! Form::label('name' , trans('validation.attributes.modules_name'), ['class' => 'col-md-2 control-label']) !!}
                                <div class="col-md-5">
                                    {!! Form::text('module-name'. '-' .$i , null, ['class' => 'form-control', 'placeholder' => trans('strings.name')]) !!} 
                                </div>
                                <a href="#" class="add-module btn btn-primary pull-left"><i class="fa fa-plus-square"></i></a>
                            </div>
                            @endfor
                        </div>
                    </div>

                    {!! Form::close() !!}
                </div>  







            </div>






        </div>

        <div id="aggregate-saap" class="tab-pane ">

            <table id="aggregated-saap-table" class="table table-bordered table-hover dataTable" role="grid">
                <thead>
                    <tr role="row">
                        <th aria-label="SAAP" aria-sort="ascending"  aria-controls="nome" tabindex="0" class="sorting_asc">SAAP Associado</th>
                        <th aria-label="Excluir"  aria-controls="excluir" tabindex="0" class="sorting">Excluir</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>

            <div id="fields">
                <div class="box box-primary" style="margin-top:30px;">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{  trans('validation.attributes.add_saap') }}</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    {!! Form::open(['route' => 'admin.courses.aggregate.store', 'class' => 'form-horizontal','id' => 'exam_id', 'role' => 'form', 'method' => 'post', 'files' => false]) !!}
                    <div class="box-body">
                        <div class="row">
                            @for( $i = 0; $i < 1; $i++)
                            <div class="form-group">

                                {!! Form::label('name' , trans('validation.attributes.add_saap'), ['class' => 'col-md-2 control-label']) !!}
                                <div class="col-md-5">
                                    {!! Form::select('exam_id',$exams,$exams, ['class' => 'form-control select2']) !!}
                                </div>

                                <div class="col-lg-10">

                                </div><!-- /.col -->
                                <a href="#" class="aggregate-saap-to-course btn btn-primary pull-left"><i class="fa fa-plus-square"></i></a>
                            </div>
                            @endfor
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>  







            </div>






        </div>


        <div id="lessons" data-selected-module="0" class="tab-pane">
            <table id="lessons-table" class="table table-bordered table-hover dataTable" role="grid">
                <thead>
                    <tr role="row">
                        <th aria-label="Id" aria-sort="ascending" aria-controls="id" tabindex="0" class="sorting">Id</th>
                        <th aria-label="Titulo" aria-sort="ascending"  aria-controls="name" tabindex="0" class="sorting_asc">Sequência</th>
                        <th aria-label="Sequencia"  aria-controls="sequence" tabindex="0" class="sorting">Nome</th>
                        <th aria-label="Blocos" aria-controls="sequence" tabindex="0" class="sorting">Blocos</th>
                        <th aria-label="Questões" aria-controls="questions" tabindex="0" class="sorting">Questões</th>
                        <th aria-label="Excluir"  aria-controls="delete" tabindex="0" class="sorting">Delete</th>
                    </tr>
                </thead>





            </table>







            <div id="lesson-fields">
                <div class="box box-primary" style="margin-top:30px;">
                    <div class="box-header with-border">
                        <h3 class="box-title">Adicionar Aulas</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body lesson-box">
                        {!! Form::open(['route' => 'admin.modules.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post']) !!}
                        <div class="form-group">
                            <div class="col-md-1"></div>
                            <div class="col-md-3">
                                <strong>Título da aula</strong>
                            </div>
                            <div class="col-md-3">
                                <strong>Sequência</strong>
                            </div>
                            <div class="col-md-3">
                                <strong>Duração em minutos</strong>
                            </div>
                        </div>
                        @for( $i = 0; $i < 4; $i++)
                        <div class="form-group lesson-fields" name="lesson-group">
                            <div class="col-md-1"></div>

                            <div class="form-input col-md-3">
                                {!! Form::text('lesson-name'. '-' .$i , null, ['class' => 'form-control', 'placeholder' => trans('strings.name')]) !!}
                            </div>
                            <div class="form-input col-md-3">
                                {!! Form::text('lesson-sequence'. '-' .$i , null, ['class' => 'form-control', 'placeholder' => trans('strings.sequence')]) !!}
                            </div>
                            <div class="form-input col-md-3">
                                {!! Form::text('lesson-duration'. '-' .$i , null, ['class' => 'form-control', 'placeholder' => trans('strings.duration')]) !!}

                            </div>
                            <div class="col-md-2">
                                <a href="#" class="add-lesson  btn btn-primary fa fa-plus-square"></a>
                            </div>
                        </div>
                        @endfor
                    </div>



                    {!! Form::close() !!}
                </div>
            </div>

        </div>


        @include('backend.courses.course-questions-tab')

    </div>
</div>

@include('backend.courses.preview')

<div class="modal fade"  id="groupSubjectModal" tabindex="-1" role="dialog" ></div>

@stop