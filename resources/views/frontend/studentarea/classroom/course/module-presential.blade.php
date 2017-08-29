<table class="table table-hover mb-none" style="margin-top: 20px; font-size:1.6rem">

    <tbody>
    @foreach ($modulespresential as $modulelist)
        {{--*/ $contentlist = get_module_first_content($modulelist); /*--}}
        {{--*/ $colorpercentage = ($modulelist->percentage_viewed < 40 ? "danger" : ($modulelist->percentage_viewed < 70 ? "warning" : "success")); /*--}}
        {{--*/ $content = get_module_first_content($modulelist); /*--}}
        @if ($contentlist != null)

            <tr>
                <td width="50%">
                    <a href="/classroom/{{ $content->lesson->module->course->id }}/{{ $modulelist->id }}/{{ $contentlist->lesson_id }}/1/{{ $enrollment->id }}">
                        {{ $modulelist->name }}
                    </a>
                </td>
                <td width="30%">
                    <div class="progress" style="height:4px; margin-top: 10px">
                                                         <span style="width: {{ $viewed =  $modulelist->percentage_viewed }}%;" class="progress-bar progress-bar-{{ $colorpercentage }}">
                                                                            <span class="sr-only">{{ $viewed }}% progress</span>
                                                         </span>
                    </div>
                </td>


                <td width="20%" class="text-right">
                                                        <span class="label label-{{ $colorpercentage }}">
                                                    {{ number_format($modulelist->percentage_viewed, 0, ',', '.' ) }} %
                                                            </span>
                </td>
            </tr>
        @endif
    @endforeach
    </tbody>
</table>
