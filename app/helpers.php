<?php

/*
 * Global helpers file with misc functions
 */

if (!function_exists('app_name')) {

    /**
     * Helper to grab the application name
     *
     * @return mixed
     */
    function app_name() {
        return config('app.name');
    }

}

if (!function_exists('access')) {

    /**
     * Access (lol) the Access:: facade as a simple function
     */
    function access() {
        return app('access');
    }

}

if (!function_exists('parse_video')) {

    /**
     * Parse url and return an object with id and video vendor
     * @param $url
     * @return array
     */
    function parse_video($url) {
        // Youtube
        if (strpos($url, 'embed/') == !false) {
            $partials = explode('embed/', $url);
            end($partials);
            return (object) ['vendor' => 'youtube', 'id' => $partials[key($partials)]];
            // Vimeo
        } else {
            $partials = explode('/', $url);
            end($partials);
            return (object) ['vendor' => 'vimeo', 'id' => $partials[key($partials)]];
        }
    }

}

if (!function_exists('format_br')) {

    /**
     * Helper to return a Carbon object from a date timestamp
     * and a custom format
     *
     * @param $date
     * @param $format
     * @return mixed
     */
    function format_br($date, $format) {
        if ($date == null)
            return "";
        else
            return Carbon\Carbon::parse($date)->format($format);
    }

}

if (!function_exists('format_datebr')) {

    /**
     * Helper to return a Carbon object from a date timestamp
     *
     * @param $date
     * @return mixed
     */
    function format_datebr($date) {
        if ($date == null)
            return "";
        else
            return Carbon\Carbon::parse($date)->format('d/m/Y');
    }

}

if (!function_exists('format_datetimebr')) {

    /**
     * Helper to return a Carbon object from a datetime timestamp
     *
     * @param $datetime
     * @return mixed
     */
    function format_datetimebr($datetime) {
        if ($datetime == null)
            return "";
        else
            return Carbon\Carbon::parse($datetime)->format('d/m/Y H:i');
    }

}

if (!function_exists('javascript')) {

    /**
     * Access the javascript helper
     */
    function javascript() {
        return app('JavaScript');
    }

}

if (!function_exists('parsebr')) {

    /**
     * Helper to format date to br and return a Carbon Object
     *
     * @param $datebr
     * @return mixed
     */
    function parsebr($datebr) {

        if (empty($datebr))
            return "";

        if (strpos($datebr, ' '))
            list($date, $hour) = explode(' ', $datebr); // Preserve hour
        else
            $date = $datebr;

        if (strpos($date, '/') == false)
            return "";

        list($day, $month, $year) = explode('/', $date);

        $timestamp = isset($hour) ? $year . '-' . $month . '-' . $day . ' ' . $hour : $year . '-' . $month . '-' . $day;
        return Carbon\Carbon::parse($timestamp);
    }

}

if (!function_exists('imageurl')) {

    /**
     * @param $entity
     * @param $id
     * @param $photo
     * @param int $size
     * @param string $alternate
     * @return mixed|string
     * @throws Exception
     */
    function imageurl($entity, $id, $photo, $size = 0, $alternate = "generic.png", $square = false) {
        if ($size === 0) {
            $size = '';
        } else {
            if ($square) {
                $size = '_square' . $size;
            } else {
                $size = '_size' . $size;
            }
        }

        $photo = '/uploads/' . $entity . $id . '/' . substr($photo, 0, strrpos($photo, '.')) . $size . strtolower(substr($photo, strrpos($photo, '.')));

        //O getimagesize funciona melhor que o file_exists nesse caso. O @ � usado para a fun��o retornar false ao inv�s
        //de atirar um erro.


        if (!@getimagesize('.' . $photo)) {
            $photo = "/img/system/" . $alternate;
            if ($size != '') {
                $photo = substr($photo, 0, strrpos($photo, '.')) . $size . strtolower(substr($photo, strrpos($photo, '.')));
            }
        }
        return $photo;
    }

}

if (!function_exists('get_filetype')) {

    function get_filetype($url) {
        return strtolower(substr($url, strrpos($url, '.')));
    }

}

if (!function_exists('img_sizes')) {

    /**
     * @param $path
     * @param $img
     * @return array
     */
    function img_sizes($path, $img) {
        if (!preg_match('/\.(gif|jpg|jpeg|tiff|png)$/', $img))
            return NULL;

        list($img_name, $img_extension) = explode('.', $img);

        $dimensions = Config::get('imageupload.dimensions');

        $sources = [];
        $sources['original'] = $path . '/' . $img;
        foreach ($dimensions as $key => $dimension) {
            $sources[$key] = $path . '/' . $img_name . '_' . $key . '.' . $img_extension;
        }

        return $sources;
    }

}

if (!function_exists('img_sizes_html')) {

    /**
     * @param $path
     * @param $img
     * @return array
     */
    function img_sizes_html($path, $img) {
        if (!preg_match('/\.(gif|jpg|jpeg|tiff|png)$/', $img))
            return NULL;

        list($img_name, $img_extension) = explode('.', $img);

        $dimensions = Config::get('imageupload.dimensions');

        $sources = [];
        $sources['original'] = '<img src="' . $path . '/' . $img . '" />';
        foreach ($dimensions as $key => $dimension) {
            $sources[$key] = '<img src="' . $path . '/' . $img_name . '_' . $key . '.' . $img_extension . '" />';
        }

        return $sources;
    }

}

if (!function_exists('prepare_tags')) {

    /**
     * @param $tags_string

     * @return array
     */
    function prepare_tags($tags_string) {
        $tags = [];
        foreach (explode(';', $tags_string) as $tag) {
            $tags[$tag] = $tag;
        }
        return $tags;
    }

}


if (!function_exists('diff_time')) {

    /**
     * @param $tags_string

     * @return array
     */
    function diff_time($date) {
        //$dateCarbon = Carbon\Carbon::createFromDate( $date);

        if (is_string($date)) {
            $date = Carbon\Carbon::parse($date);
        }

        $minutes = Carbon\Carbon::now()->diffInMinutes($date);

        if ($minutes < 60) {
            return $minutes . 'mi';
        } else {
            $hours = Carbon\Carbon::now()->diffInHours($date);
            if ($hours < 24) {
                return $hours . 'hr';
            } else {
                $days = Carbon\Carbon::now()->diffInDays($date);
                if ($days < 30) {
                    return $days . 'di';
                } else {
                    $months = Carbon\Carbon::now()->diffInMonths($date);
                    return $months . 'me';
                }
            }
        }
    }

}

if (!function_exists('get_parameter_or_session')) {

    /**
     * @param $tags_string

     * @return array
     */
    function get_parameter_or_session($request, $name, $test, $submit, $default) {

        $value = $request->input($name, $test);
        if (($submit != '1') && ($value === $test)) {
            $value = $request->session()->get($name, $test);
        }
        if ($value === '') {
            $value = $default;
        }
        $request->session()->put($name, $value);
        return $value;
    }

}

if (!function_exists('parsemoneybr')) {

    /**
     * Helper to format money to br
     *
     * @param $val
     * @return mixed
     */
    function parsemoneybr($val) {

        if (empty($val))
            return "";

        $val = str_replace('.', '', $val);
        $val = str_replace(',', '.', $val);

        return (float) $val;
    }

}

if (!function_exists('parseminutebr')) {

    /**
     * Helper to format money to br
     *
     * @param $val
     * @return mixed
     */
    function parseminutebr($val) {

        if (empty($val))
            return "";

        $val = str_replace(',', '.', $val);

        return (float) $val;
    }

}

if (!function_exists('get_vimeo_thumbnail')) {

    function get_vimeo_thumbnail($video_id, $size) {
        $file = @file_get_contents("https://vimeo.com/api/v2/video/" . $video_id . ".php");
        if ($file == false) {
            return "http://placehold.it/280x140";
        }
        $hash = unserialize($file);
        return $hash[0]['thumbnail_' . $size];
    }

}


//******************************************************************************************************************
//A partir desse ponto, isso não deve fazer parte do helpers.js e sim dos controllers. Prioridade alta refatorar   *
//******************************************************************************************************************
if (!function_exists('get_total_percentage')) {

    function get_total_percentage($enrollment) {

        $total_percentage = $enrollment->views->sum('percent') / get_contents_count($enrollment);

        return number_format($total_percentage, 2);
    }

}

if (!function_exists('get_total_percentage_completed')) {

    function get_total_percentage_completed($enrollment) {

        $count = get_contents_count($enrollment);
        if ($count === 0)
            return 0;
        $total_percentage = $enrollment->views->filter(function($item) {
                    return $item->view > 0;
                })->count() / $count;

        return number_format($total_percentage * 100, 0);
    }

}


if (!function_exists('get_contents_count')) {

    function get_contents_count($enrollment) {
        if ($enrollment->course != null) {
            return ($enrollment->course->modules->reduce(function($carry, $item) {

                        return $carry + $item->lessons->reduce(function ($carry, $item) {

                                    return $carry + $item->contents->whereLoose('is_video', '1')->count();
                                }, 0);
                    }, 0));
        } else if ($enrollment->module != null) {
            return $enrollment->module->lessons->reduce(function ($carry, $item) {
                        return $carry + $item->contents->whereLoose('is_video', 1)->count();
                    }, 0);
        } else {

            return $enrollment->lesson->contents->whereLoose('is_video', 1)->count();
        }
    }

}

if (!function_exists('get_module_lessons_by_teacher_count')) {

    function get_module_lessons_by_teacher($module) {
        $teachers = [];
        $module->lessons->each(function($lesson, $key) use($teachers) {
            $lesson->teachers->each(function($teacher_lesson, $key) use($teachers) {
                if (isset($teachers[$teacher_lesson->teacher_id])) {
                    $teachers[$teacher_lesson->teacher_id] ++;
                }
                $teachers[$teacher_lesson->teacher_id] = 0;
            });
        });
        return $teachers;
    }

}



if (!function_exists('get_questions_count')) {

    function get_questions_count($exam, $group = null, $execution_only = false) {

        if ($group != null) {

            $count = ($exam->groups->where('id', $group->id)->reduce(function($carry, $item) use($group) {
                        return $carry + $item->questions->count();
                    }, 0));

            if ($count == 0)
                return 1;

            return $count;
        }

        if ($execution_only === true) {
            return $exam->questions_executions->count();
        }



        $count = ($exam->groups->reduce(function($carry, $item) {
                    return $carry + $item->questions->count();
                }, 0));

        if ($count == 0)
            return 1;

        return $count;
    }

}

if (!function_exists('get_lessons_count')) {

    function get_lessons_count($enrollments) {
        return $enrollments->reduce(function($carry, $item) {
                    return $carry + $item->course->modules->reduce(function($carry, $item) {
                                return $carry + $item->lessons->count();
                            }, 0);
                }, 0);
    }

}

if (!function_exists('get_lessons_count_by_course')) {

    function get_lessons_count_by_course($enrollment) {
        return $enrollment->course->modules->reduce(function($carry, $item) {
                    return $carry + $item->lessons->count();
                }, 0);
    }

}



if (!function_exists('get_modules_count')) {

    function get_modules_count($enrollments) {
        return $enrollments->reduce(function($carry, $item) {
                    return $carry + $item->course->modules->count();
                }, 0);
    }

}


if (!function_exists('get_remaining_time')) {

    function get_remaining_time($enrollment) {
        $end_date = new Carbon\Carbon($enrollment->date_end);
        Carbon\Carbon::setLocale('pt_BR');

        return $end_date->diffForHumans(Carbon\Carbon::now());
    }

}

if (!function_exists('get_remaining_time_days')) {

    function get_remaining_time_days($enrollment) {
        $end_date = new Carbon\Carbon($enrollment->date_end);


        return Carbon\Carbon::now()->diffInDays($end_date, false);
    }

}

if (!function_exists('get_course_workload')) {

    function get_course_workload($enrollment) {
        $end_date = new Carbon\Carbon($enrollment->date_end);


        if ($end_date->diffInWeeks(Carbon\Carbon::now()) == 0)
            return ceil(get_contents_count($enrollment));
        return ceil(get_contents_count($enrollment) / $end_date->diffInWeeks(Carbon\Carbon::now()));
    }

}

if (!function_exists('get_url_from_content')) {

    function get_url_from_content($content) {
        if ($content == null)
            return '';

        $lesson = $content->lesson;

        $url = $lesson->id;
        $module = $lesson->module;
        if ($module != null) {
            $url = $module->id . '/' . $url;
            $course = $module->course;

            if ($course != null) {
                $url = $course->id . '/' . $url;
            }


            $url = $url . '/' . $content->sequence;
        }
        return 'classroom/' . $url;
    }

}

if (!function_exists('diff_date_by_days')) {

    function diff_date_by_days($end, $beggining) {
        $first = new \Carbon\Carbon($beggining);
        $ending = new \Carbon\Carbon($end);

        return $ending->diffInDays($first);
    }

}

if (!function_exists('get_ideal_percentage')) {

    function get_ideal_percentage($date_end, $date_begin) {
        $total = diff_date_by_days($date_end, $date_begin);
        $actual = diff_date_by_days(\Carbon\Carbon::now(), $date_begin);


        if ($total == 0) {
            return 0;
        }


        return number_format(($actual / $total) * 100, 0);
    }

}

if (!function_exists('get_last_viewed_content')) {

    function get_last_viewed_content($enrollment) {

        $last_viewed = $enrollment->views->sortBy('updated_at')->last();

        if ($last_viewed == null) {
            return null;
        }

        return $last_viewed->content;
    }

}

//Não usar essa função por enquanto, até vermos a inconsistẽncia do banco
if (!function_exists('get_next_lesson_url')) {

    function get_next_lesson_url($content, $get_next) {

        $module = $content->lesson->module;
        $lessons = $module->lessons;

        $sequence = $content->lesson->sequence;

        if ($get_next) {
            $lessons = $lessons->filter(function($lesson) use ($sequence) {
                return (intval($lesson->sequence) > intval($sequence)) && $lesson->is_active == 1;
            });
            //$lessons = $lessons->sortBy(intval($sequence));
            $lessons = $lessons->sortBy(function($item) {
                return intval($item->sequence);
            });
            $next = $lessons->first();
        } else {
            $lessons = $lessons->filter(function($lesson) use ($sequence) {
                return intval($lesson->sequence) < intval($sequence) && $lesson->is_active == 1;
            });
            $lessons = $lessons->sortByDesc(function($item) {
                return intval($item->sequence);
            });
            $next = $lessons->first();
        }



        if ($next == null)
            return "#";
        return '/classroom' . '/' . $module->course->id . '/' . $module->id . '/' . $next->id;
    }

}


if (!function_exists('student_since')) {

    function student_since($created_at) {
        $joined = new \Carbon\Carbon(($created_at));

        return $joined->toFormattedDateString();
    }

}

if (!function_exists('validateDate')) {

    function validateDate($date, $format = 'd/m/Y') {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

}

if (!function_exists('get_first_content')) {

    function get_first_content($enrollment) {

        if ($enrollment->course != null) {
            $modules = $enrollment->course->modules->reject(function($item) {
                return $item->lessons === null || $item->lessons->isEmpty();
            });
            $first_module = $modules->sortBy('sequence')->first();
            if ($first_module->sequence == null || $first_module->sequence == 0) {
                $first_module = $modules->sortBy('id')->first();
            }
            if ($first_module->lessons == null || $first_module->lessons->isEmpty()) {
                
            }

            $first_lesson = $first_module->lessons->sortBy('sequence')->first();

            if ($first_lesson->sequence == null || $first_lesson->sequence == 0) {
                $first_lesson = $first_module->lessons->sortBy('id')->first();
            }
            return $first_lesson->contents->first();
        }
        return null;
    }

}

if (!function_exists('get_attempted')) {

    function get_attempted($enrollment) {
        if ($enrollment->executions->isEmpty())
            return 0;

        return $enrollment->executions->sortByDesc('attempt')->first()->attempt;
    }

}


if (!function_exists('get_partial_rights')) {

    function get_partial_rights($execution) {
        $right = $execution->questions_executions->reduce(function ($carry, $item) {
            $count = 0;
            if ($item->answersExecution != null)
                $count = $item->answersExecution->where('question_execution_id', $item->id)->where('is_right', 1)->count();


            return $carry + $count;
        }, 0);

        return $right;
    }

}


if (!function_exists('get_rights')) {

    function get_rights($enrollment) {
        $executions = $enrollment->executions->filter(function($item) {
            return $item->finished == 1 || $item->simulation_mode;
        });
        $rights = collect([]);

        foreach ($executions as $execution) {

            $right = $execution->grade;


            if ($execution->grade == null) {
                $right = $execution->questions_executions->reduce(function ($carry, $item) {
                    $count = 0;
                    if ($item->answersExecution != null)
                        $count = $item->answersExecution->where('question_execution_id', $item->id)->where('is_right', 1)->count();


                    return $carry + $count;
                }, 0);

                $execution->grade = $right;
                $execution->save();
                $exam = $enrollment->exam;
                $exam->times_executed = $exam->times_executed + 1;
                $exam->average_grade = ($exam->average_grade + $right) / $exam->times_executed;
                $exam->save();
            }

            $rights->push($right);
        }

        return $rights;
    }

}

if (!function_exists('count_rights')) {

    function count_rights($enrollment) {
        $executions = $enrollment->executions;
        $highest = 0;







        foreach ($executions as $execution) {




            $right = $execution->questions_executions->sum(function($question) {
                if ($question->answersExecution == null)
                    return 0;
                return $question->answersExecution->where('is_right', 1)->count();
            });


            if ($right > $highest) {
                $highest = $right;
            }
        }


        return $highest;
    }

}

if (!function_exists('month_year_br')) {

    /**
     * Helper to return a Carbon object from a date timestamp
     *
     * @param $date
     * @return mixed
     */
    function month_year_br($date, $capital = true) {
        if ($date == null)
            return "";

        $month = Carbon\Carbon::parse($date)->format('m');
        if ($month === "01") {
            $ret = "Janeiro de " . Carbon\Carbon::parse($date)->format('Y');
        } else if ($month === "02") {
            $ret = "Fevereiro de " . Carbon\Carbon::parse($date)->format('Y');
        } else if ($month === "03") {
            $ret = "Março de " . Carbon\Carbon::parse($date)->format('Y');
        } else if ($month === "04") {
            $ret = "Abril de " . Carbon\Carbon::parse($date)->format('Y');
        } else if ($month === "05") {
            $ret = "Maio de " . Carbon\Carbon::parse($date)->format('Y');
        } else if ($month === "06") {
            $ret = "Junho de " . Carbon\Carbon::parse($date)->format('Y');
        } else if ($month === "07") {
            $ret = "Julho de " . Carbon\Carbon::parse($date)->format('Y');
        } else if ($month === "08") {
            $ret = "Agosto de " . Carbon\Carbon::parse($date)->format('Y');
        } else if ($month === "09") {
            $ret = "Setembro de " . Carbon\Carbon::parse($date)->format('Y');
        } else if ($month === "10") {
            $ret = "Outubro de " . Carbon\Carbon::parse($date)->format('Y');
        } else if ($month === "11") {
            $ret = "Novembro de " . Carbon\Carbon::parse($date)->format('Y');
        } else if ($month === "12") {
            $ret = "Dezembro de " . Carbon\Carbon::parse($date)->format('Y');
        }

        if ($capital) {
            $ret = strtoupper($ret);
        }
        return $ret;
    }

}

if (!function_exists('get_module_first_content')) {

    function get_module_first_content($module) {
        if ($module != null) {
            $first_lesson = $module->lessons->sortBy('sequence')->first();
            if ($first_lesson == null) {
                return null;
            }
            if ($first_lesson->sequence == null || $first_lesson->sequence == 0) {
                $first_lesson = $module->lessons->sortBy('id')->first();
            }
            return $first_lesson->contents->first();
        }
        return null;
    }

}


if (!function_exists('parse_time_to_sec')) {

    function parse_time_to_sec($time) {

        if (strpos($time, ':') == false) {
            return $time * 60;
        } else {

            $split = explode(':', $time);

            if (count($split) == 2)
                return ($split[0] * 60) + $split[1];
            if (count($split == 3))
                return ($split[0] * 3600) + ($split[1] * 60) + $split[2];
            else
                return 0;
        }
    }

}

if (!function_exists('parse_sec_to_time')) {

    function parse_sec_to_time($time) {
        $hour = floor($time / 3600);
        $minute = floor(($time - ($hour * 3600)) / 60);
        $seconds = floor($time - (($minute * 60) + ($hour * 3600)));

        $time_string = "";
        if ($hour != 0) {
            $time_string = str_pad($hour, 2, "0", STR_PAD_LEFT) . ':';
        }

        $time_string = $time_string . str_pad($minute, 2, "0", STR_PAD_LEFT);
        $time_string = $time_string . ':' . str_pad($seconds, 2, "0", STR_PAD_LEFT);

        return $time_string;
    }

}

if (!function_exists('parse_duration_to_time_string')) {

    function parse_duration_to_time_string($duration) {
        $hour = floor($duration / 60);
        $minutes = floor($duration - ($hour * 60));

        $time_string = str_pad($hour, 2, "0", STR_PAD_LEFT) . "h" . str_pad($minutes, 2, "0", STR_PAD_LEFT) . "m";

        return $time_string;
    }

}

if (!function_exists('parse_duration_to_sec')) {

    function parse_duration_to_sec($duration) {
        return $duration * 60;
    }

}


if (!function_exists('format_display_time')) {

    function format_display_time($seconds, $removeSeconds = false) {
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds - ($hours * 3600)) / 60);
        $seconds = $seconds - ($hours * 3600) - ($minutes * 60);

        if ($hours < 10) {
            $hours = "0" + $hours;
        }
        if ($minutes < 10) {
            $minutes = "0" + $minutes;
        }
        if ($seconds < 10) {
            $seconds = "0" + $seconds;
        }

        if ($hours != 0) {
            $time = $hours + 'h' . $minutes . 'm' . $seconds;
        } else {
            $time = $minutes . 'm' . $seconds . 's';
        }
        if ($removeSeconds === true) {
            $time = $hours . 'h' . $minutes . 'm';
        }
        return $time;
    }

}

if (!function_exists('get_best_result')) {

    function get_best_result($enrollment) {
        $executions = $enrollment->executions->filter(function($item) {
            return $item->finished == 1 || $item->simulation_mode;
        });

        $grade = 0;
        $best = null;
        $grades = 'A ';
        foreach ($executions as $execution) {
            if (($execution->grade !== null) && ($execution->grade >= $grade)) {
                $best = $execution;
                $grade = $execution->grade;
            }
        }
        return $best;
    }

}

if (!function_exists('get_questions_time')) {

    function get_questions_time($execution, $group = null) {


        if ($group == null) {
            if ($execution->enrollment->exam == null || $execution->enrollment->exam->time_by_question == null) {

                if ($execution->time == "00:00:00") {
                    $times = $execution->questions_executions->pluck('time');
                    $total = $times->sum(function($item) {
                        $pieces = explode(":", $item);
                        if (count($pieces) == 2)
                            return $seconds = ($pieces[0] * 60) + $pieces[1];
                        else
                            return 0;
                    });
                    return $total;
                }



                $time_pieces = explode(":", $execution->time);

                if (count($time_pieces) == 2) {
                    $seconds = ($time_pieces[0] * 60) + $time_pieces[1];
                } else if (count($time_pieces) == 3) {
                    $seconds = ($time_pieces[0] * 3600) + ($time_pieces[1] * 60) + ($time_pieces[2]);
                } else {
                    $seconds = ($time_pieces[0]);
                }
                $duration = $execution->enrollment->exam != null ? $execution->enrollment->exam->duration : $execution->enrollment->course->exam_duration;

                $total_seconds = (($duration * 60) - $seconds);

                return $total_seconds;
            }

            return $execution->questions_executions->reduce(function ($carry, $item) {
                        if ($item->time == null)
                            return $carry + 0;
                        $time_pieces = explode(":", $item->time);
                        $seconds = ($time_pieces[0] * 60) + $time_pieces[1];
                        return $carry + (($item->group->exam->time_by_question * 60) - $seconds);
                    }, 0);
        }else {
            return $execution->questions_executions->where('group_id', $group->id)->reduce(function ($carry, $item) {
                        if ($item->time == null)
                            return $carry + 0;
                        $time_pieces = explode(":", $item->time);
                        $seconds = ($time_pieces[0] * 60) + $time_pieces[1];
                        return $carry + (($item->group->exam->time_by_question * 60) - $seconds);
                    }, 0) + 1;
        }
    }

}

if (!function_exists('lessons_completed')) {


    function lessons_completed($enrollment) {

        $views = App\View::join('contents', 'contents.id', '=', 'view.content_id')->join('lessons', 'lessons.id', '=', 'contents.lesson_id')->where('view', '>', 0)->where('is_video', 1)->where('enrollment_id', $enrollment->id)->select('lesson_id as lesson', DB::raw('count(contents.id) as viewed'))->groupBy('lesson_id')->get();



        $total_lessons = 0;

        foreach ($views as $view) {

            $contents_total = App\Lesson::find($view->lesson);
            if ($contents_total !== null) {
                $contents_total = $contents_total->contents->whereLoose('is_video', '1')->count();
                $contents_viewed = $view->viewed;

                if ($contents_total == $contents_viewed)
                    $total_lessons++;
            }
        }

        return $total_lessons;
    }

}

if (!function_exists('get_subjects')) {

    function get_subjects($execution) {
        $groups = $execution->questions_executions->reject(function($item) {
                    return $item->grade === null || $item->question->subject->courses->isEmpty();
                })->unique(function($item) {
            return $item->question->subject->id;
        });

        $subject_array = [];
        foreach ($groups as $group) {
            $subject_array[$group->question->subject->id] = $group->question->subject->courses;
        }


        return $subject_array;
    }

}

if (!function_exists('get_courses_from_exam')) {

    function get_courses_from_exam($exam) {
        $subjects = collect([]);

        foreach ($exam->groups as $group) {
            foreach ($group->questions as $question) {
                if (!$question->subject->courses->isEmpty()) {
                    if (!isset($subjects[$question->subject_id]))
                        $subjects[$question->subject_id] = collect(["courses" => $question->subject->courses, "groups" => collect([$group->id])]);
                    else
                        $subjects[$question->subject_id]["groups"]->push($group->id);
                }
            }
        }


        $courses_set = collect([]);
        foreach ($subjects as $subject => $courses) {
            foreach ($courses["courses"] as $course) {
                if (!isset($courses_set[$course->id])) {
                    $courses_set[$course->id] = ["course" => $course, "group" => $courses["groups"]];
                } else {
                    $courses_set[$course->id]["group"]->push($courses["groups"]->intersect($courses_set[$course->id]["group"]));
                }
            }
        }
        return $courses_set;
    }

}

if (!function_exists('get_courses_from_parent_subjects')) {

    function get_courses_from_parent_subjects($subjects) {


        $courses_set = collect([]);
        foreach ($subjects as $subject => $courses) {
            foreach ($courses["courses"] as $course) {


                if (!isset($courses_set[$course->id])) {
                    $courses_set[$course->id] = ["course" => $course, "subject" => $courses["children"], "subject-parent" => $subject];
                } else {
                    $courses_set[$course->id]["subject"]->push($courses["children"]->diff($courses_set[$course->id]["subject"]));
                }
            }
        }


        return $courses_set;
    }

}


if (!function_exists('get_parents_with_courses')) {

    function get_parents_with_courses($exam, $rs) {



        $subjects = collect([]);



        foreach ($rs->reject(function($item)use($exam) {
            return (($item["rights"] / $item["total"] ) * 100) > $exam->minimum_percentage;
        }) as $name => $r) {


            $sons = Collect([$r["sons"]]);

            //if($name == "Aviso Prévio e Extinção do Contrato") dd($r["object"]->courses->filter(function($item) use($exam){ dd($item->pivot->exam_id); return (($item->pivot->exam_id == $exam->id || $item->pivot->exam_id == null) && $item->is_active == 1);}));
            if (Auth::user()->id == 1 || Auth::user()->id == 131 || Auth::user()->id == 13251 || Auth::user()->id == 13669 || Auth::user()->id == 10361 || Auth::user()->id == 12377 || Auth::user()->id == 352 || Auth::user()->id == 355 || Auth::user()->id == 14033) {
                $courses = Collect($r["object"]->courses->filter(function($item) use($exam) {
                            return (($item->pivot->exam_id == $exam->id || $item->pivot->exam_id == null));
                        }));
            } else {

                $courses = Collect($r["object"]->courses->filter(function($item) use($exam) {
                            return (($item->pivot->exam_id == $exam->id || $item->pivot->exam_id == null) && $item->is_active == 1);
                        }));
            }



            foreach ($sons as $son) {
                foreach ($son as $single) {


                    //dd($single['object']->courses);

                    if (!$single["object"]->courses->isEmpty())
                        if (Auth::user()->id == 1 || Auth::user()->id == 13251 || Auth::user()->id == 131 || Auth::user()->id == 13669 || Auth::user()->id == 10361 || Auth::user()->id == 12377 || Auth::user()->id == 352 || Auth::user()->id == 355 || Auth::user()->id == 14033) {
                            $courses = $courses->merge($single["object"]->courses->filter(function($item) use($exam) {
                                        return (($item->pivot->exam_id == $exam->id || $item->pivot->exam_id == null));
                                    }));
                        } else {
                            $courses = $courses->merge($single["object"]->courses->filter(function($item) use($exam) {
                                        return (($item->pivot->exam_id == $exam->id || $item->pivot->exam_id == null) && $item->is_active == 1);
                                    }));
                        }
                }
            }





            if (!$courses->isEmpty())
                $subjects[$r["id"]] = collect(["courses" => $courses, "children" => collect($sons->pluck('object')->pluck('id'))]);
        }



        return $subjects;
    }

}

if (!function_exists('get_packages_from_parent_subjects')) {

    function get_packages_from_parent_subjects($subjects) {


        $packages_set = collect([]);
        foreach ($subjects as $subject => $packages) {
            foreach ($packages["packages"] as $package) {


                if (!isset($packages_set[$package->id])) {
                    $packages_set[$package->id] = ["package" => $package, "subject" => $packages["children"], "subject-parent" => $subject];
                } else {
                    $packages_set[$package->id]["subject"]->push($packages["children"]->diff($packages_set[$package->id]["subject"]));
                }
            }
        }

        return $packages_set;
    }

}

if (!function_exists('get_course_helper')) {

    function get_course_helper($course_id) {
        $course = App\Course::where('id', '=', $course_id)->first();
        return $course;
    }

}

if (!function_exists('get_total_itens_order_helper')) {

    function get_total_itens_order_helper($order_id, $course_id) {
        $course = App\OrderCourse::where('order_id', '=', $order_id)
                ->where('course_id', '=', $course_id)
                ->get();
        return count($course);
    }

}













if (!function_exists('get_parents_with_packages')) {

    function get_parents_with_packages($exam, $rs) {



        $subjects = collect([]);




        foreach ($rs->reject(function($item)use($exam) {
            return (($item["rights"] / $item["total"] ) * 100) > $exam->minimum_percentage;
        }) as $name => $r) {


            $sons = Collect([$r["sons"]]);

            $packages = Collect($r["object"]->packages->filter(function($item) use($exam) {
                        return (($item->pivot->exam_id == $exam->id || $item->pivot->exam_id == null) && $item->is_active == 1);
                    }));




            foreach ($sons as $son) {
                foreach ($son as $single) {

                    if (!$single["object"]->packages->isEmpty())
                        $packages = $packages->merge($single["object"]->packages->filter(function($item) use($exam) {
                                    return (($item->pivot->exam_id == $exam->id || $item->pivot->exam_id == null) && $item->is_active == 1);
                                }));
                }
            }





            if (!$packages->isEmpty())
                $subjects[$r["id"]] = collect(["packages" => $packages, "children" => collect($sons->pluck('object')->pluck('id'))]);
        }



        return $subjects;
    }

}




if (!function_exists('get_questions_from_exam')) {

    function get_questions_from_exam($exam) {

        $teachers = collect([]);

        foreach ($exam->groups as $group) {
            foreach ($group->questions as $question) {

                if ($question->teacher != null && !isset($teachers[$question->teacher->id])) {
                    $teachers[$question->teacher->id] = $question->teacher;
                }
            }
        }



        return $teachers;
    }

}


if (!function_exists('is_exam_tries_over')) {

    function is_exam_tries_over($enrollment) {
        $max_tries = $enrollment->exam_max_tries != null ? $enrollment->exam_max_tries : $enrollment->exam->max_tries;
        $executions = $enrollment->executions;

        if ($executions->isEmpty())
            return false;
        if ($executions->whereLoose('finished', 1)->isEmpty())
            return false;

        if ($max_tries > $executions->whereLoose('finished', 1)->max('attempt')) {
            return false;
        }

        return true;
    }

}



if (!function_exists('get_ads')) {

    function get_ads() {

        $ads = null;

//        if (session('ads') != null && is_array(session('ads'))) {
//           
//            $storing = session('ads');
//            $ads = Collect();
//            foreach ($storing as $store) {
//                $ads->push(App\Course::hydrate($store));
//            }
//
//            $ads = $ads[0];
//        } else {

        $ads = App\Course::with('subsection.section')
                ->where('is_active', 1)
                ->where('activation_date', '<=', Carbon\Carbon::now())
                ->where('featured', 1)
                ->orderByRaw("RAND()")
                ->get()
                ->take(4);

//
//            $storing = $ads->map(function ($product) {
//                        return $product->getAttributes();
//                    })->all();
//
//            Session::push('ads', $storing);
//        }

        return $ads;
    }

}

if (!function_exists('get_ads_per_section')) {

    function get_ads_per_section($section_id) {

        $query = App\Course::with('subsection.section')->where()->where('is_active', 1)->where('activation_date', '<=', Carbon\Carbon::now())->where('featured', 1);

        if (!empty($section_id)) {
            $query->where('section_id', '=', $section_id);
        }
        $ads = $query->get()->shuffle()->take(4);

        $storing = $ads->map(function ($product) {
                    return $product->getAttributes();
                })->all();


        return $ads;
    }

}


if (!function_exists('content_notes')) {

    function content_notes($student_id, $content_id) {
        return App\ContentNote::where('student_id', '=', $student_id)->where('content_id', '=', $content_id)->orderBy('video_index_seconds', 'asc')->get();
    }

}

if (!function_exists('get_enrollment_by_user_course_enrollment')) {

    function get_enrollment_by_user_course_enrollment($exam, $enrollment) {
        $exam_enrollment = App\Enrollment::where('exam_id', $exam)->where('course_enrollment_id', $enrollment->id)->where('date_end', '>=', Carbon\Carbon::now())->where('course_id', null)->where('is_active', 1)->first();

        return $exam_enrollment;
    }

}

if (!function_exists('user_has_enrollments_in_course_type')) {

    function user_has_enrollments_in_course_type($field, $comparator, $value) {
        return !(App\Enrollment::where('student_id', Auth()->user()->id)
                        ->whereHas('course', function($query) use($field, $comparator, $value) {
                            $query->where($field, $comparator, $value);
                        })->where('is_active', 1)->where('date_end', '>=', Carbon\Carbon::today())->get()->isEmpty());
    }

};

if (!function_exists('user_has_ask_the_tutor')) {

    function user_has_ask_the_tutor() {
        return !(App\AskTheTeacher::where('user_student_id', Auth()->user()->id)
                        ->get()->isEmpty());
    }

};

if (!function_exists('user_has_enrollments_in_exam_type')) {

    function user_has_enrollments_in_exam_type($field, $comparator, $value) {
        return !(App\Enrollment::where('student_id', Auth()->user()->id)->whereHas('exam', function($query)use($field, $comparator, $value) {
                    $query->where($field, $comparator, $value);
                })->where('is_active', 1)->get()->isEmpty());
    }

};



if (!function_exists('get_current_year')) {

    function get_current_year() {
        return \Carbon\Carbon::today()->year;
    }

}

if (!function_exists('count_viewed')) {

    function count_viewed($viewed) {
        $count = 0;
        foreach ($viewed as $view) {
            if ($view !== 0) {
                $count++;
            }
        }

        return $count;
    }

}

if (!function_exists('get_logo')) {

    function get_logo() {
        $origin = app('session')->get('origin');
        $logo = "";
        if (($origin != null) && ($origin == 'compliance')) {
            $logo = "/img/system/x.png";
        }

        if ($logo == "") {
            $logo = "/img/system/logo-brj.png";
        }
        return $logo;
    }

}

if (!function_exists('get_classroom_header')) {

    function get_classroom_header() {
        $origin = app('session')->get('origin');
        $header = "";
        if (($origin != null) && ($origin == 'compliance')) {
            $header = "frontend.includes.compliance.classroom-header";
        }

        if ($header == "") {
            $header = "frontend.includes.classroom-header";
        }
        return $header;
    }

}


if (!function_exists('has_execution_in_lesson_finished')) {

    function has_execution_in_lesson_finished($enrollment, $lesson) {
        $count = App\Execution::where('enrollment_id', $enrollment->id)->where('finished', '=', 1)->where('lesson_id', $lesson->id)->count();


        if ($count > 0)
            return true;
        return false;
    }

}


if (!function_exists('get_course_with_associated_exam')) {

    function get_course_with_associated_exam($exam) {
        if ($exam->course != null && !$exam->course->isEmpty()) {
            return $exam->course;
        }
        return null;
    }

}

if (!function_exists('exam_has_subject')) {

    function exam_has_subject($exam) {
        return !App\Lesson::join('modules', 'modules.id', '=', 'lessons.module_id')->join('courses', 'modules.course_id', '=', 'courses.id')->
                        join('courses_aggregated_exams', 'courses_aggregated_exams.course_id_bought', '=', 'courses.id')
                        ->join('groups', 'groups.lesson_id', '=', 'lessons.id')->
                        join('group_subject', 'group_subject.group_id', '=', 'groups.id')->join('subjects as s1', 's1.id', '=', 'group_subject.subject_id')->
                        join('subjects as s2', 's2.id', '=', 's1.subject_id')->where('courses_aggregated_exams.exam_id_extra', $exam->id)->
                        select('lessons.*')->get()->isEmpty();
    }

}
/**
 * Function to return to the logged in user is Partner Manager
 * @return boolean
 */
if (!function_exists('is_partner_manager')) {

    function is_partner_manager() {
        return (count(App\PartnerManager::join('users', 'users.id', '=', 'partner_managers.user_id')
                                ->join('partners', 'partners.id', '=', 'partner_managers.partner_id')
                                ->where('users.id', '=', Auth()->user()->id)
                                ->selectRaw('users.name as user_name, users.email as user_email, partners.name as partners_name')
                                ->get()) > 0) ? true : false;
    }

}

/**
 * Function to return the partners the logged user is allowed
 * @return array mixed
 */
if (!function_exists('has_permission_partner')) {

    function has_permission_partner() {
        $hasPartnerUser = [];
        $query = App\PartnerManager::join('users', 'users.id', '=', 'partner_managers.user_id')
                ->join('partners', 'partners.id', '=', 'partner_managers.partner_id')
                ->where('users.id', '=', Auth()->user()->id)
                ->selectRaw('partners.id AS partners_id')
                ->get();
        foreach ($query as $partner) {
            $hasPartnerUser[] = $partner->partners_id;
        }
        return $hasPartnerUser;
    }

}

if (!function_exists('average_workshop_grade')) {

    function average_workshop_grade($workshop) {
        $activities_count = 0;

        $total_grade = $workshop->activities->reduce(function($carry, $activity) use(&$activities_count) {



            $myactivity = $activity->myactivity->first();


            if ($myactivity != null) {



                $evaluations = $myactivity->evaluation->reject(function($item) {
                    return $item->grade === null;
                });
                if (!$evaluations->isEmpty()) {
                    $activities_count++;

                    return $carry + average_workshop_activity_grade($evaluations);
                } else {
                    return $carry;
                }
            } else {
                return $carry;
            }
        }, 0);


        if ($activities_count == 0)
            return 0;
        return $total_grade / $activities_count;
    }

}

if (!function_exists('average_workshop_activity_grade')) {

    function average_workshop_activity_grade($evaluations) {
        return $evaluations->unique('criteria_id')->sum('grade');
    }

}

if (!function_exists('findWorkshop')) {

    function findWorkshop($id) {
        return App\Workshop::where('id', '=', $id)->get()->first();
    }

}

if (!function_exists('timeConverterMilisecondToMinute')) {

    function timeConverterMilisecondToMinute($_timeValue) {
        $total = $_timeValue;
        $horas = floor($total / 3600);
        $minutos = floor(($total - ($horas * 3600)) / 60);
        $segundos = floor($total % 60);
        return $horas . ":" . $minutos . ":" . $segundos;
    }

}

/**
 * 
 */
if (!function_exists('getSectionData')) {

    function getSectionData($subsection_id) {  //Type [course or exam]
        $sectionObj = App\Section::where('id', '=', $subsection_id)->get();
        return $sectionObj;
    }

}
/**
 * 
 */
if (!function_exists('getSubsectionData')) {

    function getSubsectionData($subsection_id) {  //Type [course or exam]
        $subSectionObj = App\Subsection::where('id', '=', $subsection_id)->get();
        return $subSectionObj;
    }

}

if (!function_exists('getStudentData_helper')) {

    function getStudentData_helper($student_id) {  //Type [course or exam]
        $user = App\User::where('id', '=', $student_id)->first();
        return $user;
    }

}

if (!function_exists('validateCPF_helper')) {

    function validateCPF_helper($cpf) {  //Type [course or exam]
        // Verifica se um número foi informado
        if (empty($cpf)) {
            return false;
        }

        $cpf = str_replace('.', '', $cpf);
        $cpf = str_replace('-', '', $cpf);


        // Elimina possivel mascara
//        $cpf = ereg_replace('[^0-9]', '', $cpf);
        $cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);

        // Verifica se o numero de digitos informados é igual a 11 
        if (strlen($cpf) != 11) {
            return false;
        }
        // Verifica se nenhuma das sequências invalidas abaixo 
        // foi digitada. Caso afirmativo, retorna falso
        else if ($cpf == '00000000000' ||
                $cpf == '11111111111' ||
                $cpf == '22222222222' ||
                $cpf == '33333333333' ||
                $cpf == '44444444444' ||
                $cpf == '55555555555' ||
                $cpf == '66666666666' ||
                $cpf == '77777777777' ||
                $cpf == '88888888888' ||
                $cpf == '99999999999') {
            return false;
            // Calcula os digitos verificadores para verificar se o
            // CPF é válido
        } else {

            for ($t = 9; $t < 11; $t++) {

                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $d += $cpf{$c} * (($t + 1) - $c);
                }
                $d = ((10 * $d) % 11) % 10;
                if ($cpf{$c} != $d) {
                    return false;
                }
            }

            return true;
        }
    }

    if (!function_exists('getFinalPrice')) {

        /**
         * Função para retornar o preço final de um determinado curso
         * @param array $data
         * @return mixed
         */
        function getFinalPrice($data) {
            if (($data->special_price !== null) && ($data->special_price != 0.00)) {
                $startsAt = parsebr($data->start_special_price);
                $endsAt = parsebr($data->end_special_price);
                if (($startsAt != '') && ($endsAt != '')) {
                    $startsAt = Carbon::parse($startsAt);
                    $endsAt = Carbon::parse($endsAt);
                    $inRange = Carbon::today()->between($startsAt, $endsAt, true);
                    if ($inRange)
                        return $data->special_price;
                }
            }
            return $data->discount_price;
        }

    }

    if (!function_exists('isCoordinatorCourse')) {

        /**
         * Função para retornar se o usuário logado é coordenador de algum curso
         *
         * @return bool
         */
        function isCoordinatorCourse() {
            return !App\User::join('coordinators_courses', 'coordinators_courses.coordinator_id', '=', 'users.id')
                            ->where('users.id', '=', Auth()->user()->id)->get()->isEmpty();
        }

    }
}