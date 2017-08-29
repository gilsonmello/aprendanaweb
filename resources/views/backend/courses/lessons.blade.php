<br/>
    {!! Form::model($lesson, ['route' => ['admin.lessons.update', $lesson->id], "id" => 'edit-lesson','class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH', 'files' => true]) !!}

        <div class="form-group">
            {!! Form::label('subsection_id', trans('validation.attributes.subsection'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::select('subsection_id', $subsections, $lesson->subsection_id, ['class' => 'form-control']) !!}
            </div><!-- /.col -->
        </div>

        <div class="form-group">
            {!! Form::label('title', trans('validation.attributes.title'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => trans('strings.title')]) !!}
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
    {!! Form::label('exam_id', trans('validation.attributes.exam'), ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-10">
        {!! Form::select('exam_id',['' => ''] + $exams, $lesson->exam_id, ['class' => 'form-control']) !!}
    </div><!-- /.col -->
</div>




        <div class="form-group">
            {!! Form::label('image', trans('validation.attributes.image'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! $lesson->featured_img_html['square100'] !!}
                <input type="file" name="featured_img"/>
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
            {!! Form::label('sequence', trans('validation.attributes.sequence'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('sequence', null, ['class' => 'form-control', 'placeholder' => trans('strings.sequence')]) !!}
            </div>
        </div><!--form control-->

        <div class="form-group">
            {!! Form::label('duration', trans('validation.attributes.duration'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('duration', null, ['class' => 'form-control', 'placeholder' => trans('strings.duration')]) !!}
            </div>
        </div><!--form control-->

    <!--
        <div class="form-group">
            {!! Form::label('tags', trans('validation.attributes.tags'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::select('tags[]', $lesson->tags_array, $lesson->tags_array, ['class' => 'form-control tags-select', 'multiple' => 'multiple']) !!}
            </div>
        </div>
-->
        <div class="form-group">
            {!! Form::label('activation_date', trans('validation.attributes.activation_date'), ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('activation_date', null, ['class' => 'form-control datepicker', 'placeholder' => trans('validation.attributes.activation_date')]) !!}
            </div>
        </div><!--form control-->

<div class="form-group">
    <label class="col-lg-2 control-label">{{ trans('validation.attributes.active') }}</label>
    <div class="col-lg-1">
        <div class="sw-green create-permissions-switch">
            <div class="onoffswitch">
                <input type="checkbox" value="1" name="is_active" class="toggleBtn onoffswitch-checkbox" id="lesson-active" @if($lesson->is_active == 1)checked="checked"@endif>
                <label for="course-active" class="onoffswitch-label">
                    <div class="onoffswitch-inner"></div>
                    <div class="onoffswitch-switch"></div>
                </label>
            </div>
        </div><!--green checkbox-->
    </div>
</div><!--form control-->

<div class="form-group">
    <label class="col-lg-2 control-label">{{ trans('validation.attributes.presential') }}</label>
    <div class="col-lg-1">
        <div class="sw-green create-permissions-switch">
            <div class="onoffswitch">
                <input type="checkbox" value="1" name="presential" class="toggleBtn onoffswitch-checkbox" id="lesson-presential" @if($lesson->presential == 1)checked="checked"@endif>
                <label for="lesson-presential" class="onoffswitch-label">
                    <div class="onoffswitch-inner"></div>
                    <div class="onoffswitch-switch"></div>
                </label>
            </div>
        </div><!--green checkbox-->
    </div>
</div><!--form control-->





        <div class="pull-right">
            <input id="save-lesson" name="save-lesson" type="button" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
        </div>
        <div class="clearfix"></div>

    {!! Form::close() !!}