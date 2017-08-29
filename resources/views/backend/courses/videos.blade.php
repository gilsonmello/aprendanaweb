
    {!! Form::open( ['route' => ['admin.courses.updatevideos'], 'class' => 'form-horizontal', 'id' => 'video-form', 'role' => 'form', 'method' => 'PATCH']) !!}

        <div class="form-group">
            {!!   Form::hidden('lesson_id', $lesson->id) !!}
        </div>

    @foreach($contents->sortBy('sequence') as $content)

        <div class="form-group video-address">
            {!! Form::label('video_' . $content->sequence, trans('validation.attributes.block') . ' ' . $content->sequence, ['class' => 'col-md-2 control-label']) !!}
            <div class="col-lg-8">
                {!! Form::text('video_' . $content->sequence, $content['url'], ['name' => 'video[]','data-sequence' => $content->sequence ,'class' => 'form-control col-lg-2 content-url', 'placeholder' => trans('strings.url')]) !!}
            </div><!-- /.col -->
            <div class="col-lg-2">
                <i class="fa fa-tv content-preview" data-toggle="tooltip" title="Preview do vídeo" style="cursor:pointer"></i>
            </div>
        </div>

    @endforeach



    @for ($j = $contents->count() + 1; $j <= 15; $j++)

        <div class="form-group video-address">
            {!! Form::label('video_' . $j, trans('validation.attributes.block') . ' ' . $j, ['class' => 'col-md-2 control-label']) !!}
            <div class="col-lg-8">
                {!! Form::text('video_' . $j, null, ['name' => 'video[]','class' => 'form-control content-url','data-sequence' => $j ,'placeholder' => trans('strings.url')]) !!}
            </div><!-- /.col -->
            <div class="col-lg-2">
                <i class="fa fa-tv content-preview" data-toggle="tooltip" title="Preview do vídeo" style="cursor:pointer"></i>
            </div>


        </div>
    @endfor



        <div class="pull-right">
            <input id="save-videos" name="save-videos" type="button" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
        </div>
        <div class="clearfix"></div>

    {!! Form::close() !!}


