@foreach ($modulesonline as $modulelist)
{{--*/ $lessons = $modulelist->lessons; /*--}}



@if (count($lessons))
<a data-toggle="collapse" data-target="#classes{{ $modulelist->id }}" style="cursor: pointer;">
    <i class="fa fa-folder"></i>&nbsp;&nbsp;
    {{ $modulelist->name }}
</a>

<div id="classes{{ $modulelist->id }}" class="collapse" style="width: 100%; padding-left: 30px; cursor: pointer;">

    @foreach ($lessons->sortBy('sequence') as $lessonlist)
    {{--*/ $contents = $lessonlist->contents->whereLoose('is_video', 0); /*--}}
    @if (count($contents))
    <a data-toggle="collapse" data-target="#files{{ $lessonlist->id }}">
        <i class="fa fa-folder"></i>&nbsp;&nbsp;
        Aula {{ $lessonlist->sequence }}
    </a>
    <div id="files{{ $lessonlist->id }}"  class="collapse" style="width: 100%; padding-left:30px;  cursor: pointer;">
        @foreach ($contents as $file)
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
        @endforeach
    </div>
    <br/>
    @endif
    @endforeach
</div>
<br/>
<br/>
@endif
@endforeach
