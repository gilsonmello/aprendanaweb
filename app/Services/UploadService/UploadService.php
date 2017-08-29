<?php namespace App\Services\UploadService;

use App\Repositories\Backend\Article\ArticleContract;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Log;
use Matriphe\Imageupload\Imageupload;

class UploadService
{

    /**
     * @param Filesystem $filesystem
     * @param Imageupload $imageupload
     */
    public function __construct(Filesystem $filesystem, Imageupload $imageupload)
    {
        $this->filesystem = $filesystem;
        $this->imageupload = $imageupload;
    }


    /**
     * @param $img
     * @param $relation_title
     * @param $relation_id
     * @param $entityname
     * @return array
     */
    public function addImg($img, $relation_title, $relation_id, $entityname)
    {
        $new_file_name = $this->imgNameFromTitle($relation_title);
        return $this->imageupload->upload($img, $new_file_name, '/'.$entityname.'/' . $relation_id);
    }

    /**
     * @param $img
     * @param $relation_title
     * @param $relation_id
     * @param $entityname
     * @param $to_delete
     * @return array
     */
    public function editImg($img, $relation_title, $relation_id, $entityname, $to_delete)
    {
        $new_file_name = $this->imgNameFromTitle($relation_title);

        $upload_result = $this->imageupload->upload($img, $new_file_name, '/'.$entityname.'/' . $relation_id);

        if(!isset($upload_result['error']))
            if(file_exists($to_delete['original'])) $this->filesystem->delete($to_delete);

        return $upload_result;
    }

    /**
     * Generate img slug name from title
     * @param $title
     * @return string
     */
    private function imgNameFromTitle($title)
    {
        return str_slug($title, '_') . '_' . str_random(4);
    }

}