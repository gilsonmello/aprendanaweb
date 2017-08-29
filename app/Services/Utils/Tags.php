<?php namespace App\Services\Utils;


class Tags{

    public function tagsList(&$objects){

        $tags = Collect([]);

        foreach ($objects as $object) {
            if ($object->course_id != null){
                $object = $object->course;
            } else if ($object->exam_id != null){
                $object = $object->exam;
            }

            if($object == null) continue;
            $object_tags = $object->tags;

            if ($object_tags != null && $object_tags != '') {
                $object_tags = explode(";", $object_tags);

                foreach ($object_tags as $tag) {
                    if (isset($tags[$tag])) {
                        $tags[$tag] = $tags[$tag] + 1;
                    } else {
                        $tags[$tag] = 1;
                    }
                }
            }
        }

        $tags = $tags->sortBy(function($item,$key){
            return $key;
        });

        return $tags;
    }
}