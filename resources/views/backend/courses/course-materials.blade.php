

<div id="course-materials" class="tab-pane">

    <br/>
    <div id="course-content-files" style="padding: 20px;">


        @foreach($course->course_contents as $file)
            @if(get_filetype($file->url) == '.pdf')
                <li class="fa fa-file-pdf-o">&nbsp;&nbsp;<a target="_blank" name="course-material-file" data-id="{{ $file->id }}" href="/{{ $file->url }}">{{ $file->title }}</a> <a type="button" class="fa fa-times remove-course-material" data-content="{{$file->id}}" style="cursor:pointer; color:red"></a></li>
            @elseif(get_filetype($file->url) == '.pps')
                <li class="fa fa-file-powerpoint-o" >&nbsp;&nbsp;<a target="_blank" name="course-material-file" data-id="{{ $file->id }}" data-url="/{{ $file->url }}"  href="{{ $file->url }}">{{ $file->title }}</a> <a type="button" class="fa fa-times remove-course-material" data-content="{{$file->id}}" style="cursor:pointer;color:red"></a></li>
            @elseif(get_filetype($file->url) == '.doc' || $file->url == '.docx')
                <li class="fa fa-file-word-o" >&nbsp;&nbsp;<a target="_blank" name="course-material-file" data-id="{{ $file->id }}" data-url="/{{ $file->url }}"  href="{{ $file->url }}">{{ $file->title }}</a> <a type="button" class="fa fa-times remove-course-material" data-content="{{$file->id}}" style="cursor:pointer; color:red"></a></li>
            @elseif(get_filetype($file->url) == '.png' ||$file->url == '.jpg' || get_filetype($file->url) == 'jpeg')
                <li class="fa fa-file-image-o" >&nbsp;&nbsp;<a target="_blank" name="course-material-file" data-id="{{ $file->id }}" data-url="/{{ $file->url }}"  href="{{ $file->url }}">{{ $file->title }}</a> <a type="button" class="fa fa-times remove-course-material" data-content="{{$file->id}}" style="cursor:pointer; color:red"></a></li>
            @else
                <li class="fa fa-file" >&nbsp;&nbsp;<a target="_blank" name="course-material-file"  data-id="{{ $file->id }}" data-url="/{{ $file->url }}" href="{{ $file->url }}">{{ $file->title }}</a> <a type="button" class="fa fa-times remove-course-material" data-content="{{$file->id}}" style="cursor:pointer; color:red"></a></li>
            @endif
            <br/>
        @endforeach
    </div>
    <br/>
    <br/>
    <input id="add-course-material" name="add-course-material" type="button" class="btn btn-success" value="{{ trans('strings.add') }}" />

    <br/>

    {!! Form::open( ['route' => ['admin.courses.savecoursematerial'], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'POST', 'id' => 'course-material-form','style' => 'display: none','files' => true]) !!}

    <div class="form-group">
        {!!   Form::hidden('course_id', $course->id) !!}
    </div>

    <div class="form-group">
        {!! Form::label('course-material', trans('validation.attributes.material') , ['class' => 'col-md-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('course-material', null, ['id' => 'course-material-name','name' => 'course-material','class' => 'form-control col-lg-2', 'placeholder' => trans('strings.title')]) !!}
        </div><!-- /.col -->
    </div>

    <div class="form-group">
        {!! Form::label('course-material-url', trans('validation.attributes.url') , ['class' => 'col-md-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::file('course-material-upload',null) !!}
        </div>
    </div>

    <div class="pull-right">
        <input id="save-course-material" type="submit" name="save-course-material" type="button" class="btn btn-success" value="{{ trans('strings.save_button') }}" />
    </div>
    <div class="clearfix"></div>
    {!! Form::close() !!}


</div>

