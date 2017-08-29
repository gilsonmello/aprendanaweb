
    {{--*/ $course_contents = $course->course_contents->whereLoose('is_video', 0); /*--}}

    @if (count($course_contents))



                    <div id="files-course-{{ $course->id }}"  style="width: 100%; padding-left:30px;  cursor: pointer;">
                        @foreach ($course_contents as $file)
                            @if(get_filetype($file->url) == '.pdf')
                                <i class="fa fa-file-pdf-o"></i>&nbsp;&nbsp;<a href="/{{ $file->url  }}" target="_blank">{{ $file->title }}</a>
                            @elseif(get_filetype($file->url) == '.pps')
                                <i class="fa fa-file-powerpoint-o"></i>&nbsp;&nbsp;<a href="/{{ $file->url  }}" target="_blank">{{ $file->title }}</a>
                            @elseif(get_filetype($file->url) == '.doc' || $file->url == '.docx')
                                <i class="fa fa-file-word-o"></i>&nbsp;&nbsp;<a href="/{{ $file->url  }}" target="_blank">{{ $file->title }}</a>
                            @elseif(get_filetype($file->url) == '.png' ||$file->url == '.jpg' || get_filetype($file->url) == 'jpeg')
                                <i class="fa fa-file-image-o"></i>&nbsp;&nbsp;<a href="/{{ $file->url  }}" target="_blank">{{ $file->title }}</a>
                            @else
                                <i class="fa fa-file"></i>&nbsp;&nbsp;<a href="/{{ $file->url  }}" target="_blank">{{ $file->title }}</a>
                            @endif
                            <br/>
                            <br/>
                        @endforeach
                    </div>
                    <br/>


    @endif
