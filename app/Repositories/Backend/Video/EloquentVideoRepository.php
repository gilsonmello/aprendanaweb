<?php namespace App\Repositories\Backend\Video;

use App\Video;
use App\Exceptions\GeneralException;
use Carbon\Carbon;
use App\Repositories\Backend\Tag\TagContract;


/**
 * Class EloquentVideoRepository
 * @package App\Repositories\Video
 */
class EloquentVideoRepository implements VideoContract {


    public function __construct(TagContract $tags) {
        $this->tags = $tags;
    }


	/**
	 * @param $id
	 * @return mixed
	 * @throws GeneralException
	 */
	public function findOrThrowException($id) {
		$video = Video::withTrashed()->find($id);

		if (! is_null($video)) return $video;

		throw new GeneralException('That video does not exist.');
	}

	/**
	 * @param $per_page
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getVideosPaginated($per_page, $order_by = 'id', $sort = 'asc', $f_VideoController_title = '') {
		return Video::where('title', 'like', '%'.$f_VideoController_title.'%')->orderBy($order_by, $sort)->paginate($per_page);
	}

	/**
	 * @param $per_page
	 * @return \Illuminate\Pagination\Paginator
	 */
	public function getDeletedVideosPaginated($per_page) {
		return Video::onlyTrashed()->paginate($per_page);
	}

	/**
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getAllVideos($order_by = 'id', $sort = 'asc') {
		return Video::orderBy($order_by, $sort)->get();
	}

    /**
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function create($input) {
        if ((isset($input['tags'])) && ($input['tags'] > 0)) {
            $this->tags->createIfNew($input['tags']);
        }

        $video = $this->createVideoStub($input);

        if($video->save()) {

          //  dd($input);

            if($input['teachers'])
                $video->users()->attach($input['teachers']);

            return $video;
        }
        throw new GeneralException('There was a problem creating this video. Please try again.');
    }

    /**
     * @param $id
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function update($id, $input, $teachers) {
        $video = $this->findOrThrowException($id);


        if(isset($input['tags'])){
        $this->tags->createIfNew($input['tags']);
            $input['tags'] = implode(';', $input['tags']);
        }


        if ($video->update($input)) {
            $video->title  = $input['title'];
            $video->slug = $input['slug'];
            $video->url = $input['url'];
            if(isset($input['activation_date'])) $video->activation_date = parsebr($input['activation_date']);
            $video->content = $input['content'];
            if(isset($input['tags'])) $video->tags = $input['tags'];
            if(isset($input['img'])) $video->img = $input['img'];
            $video->status = isset($input['status']) ? 1 : 0;
            $video->save();

            if($teachers['teachers'])
                $video->users()->sync($teachers['teachers']);
            else
                $video->users()->detach();
//                throw new GeneralException('É preciso selecionar pelo menos um professor para o vídeo.');

            return $video;
        }

        throw new GeneralException('There was a problem updating this video. Please try again.');
    }

    /**
     * @param $id
     * @param $new_file_name
     * @return bool
     * @throws GeneralException
     */
    public function updateImg($id, $new_file_name) {
        $video = $this->findOrThrowException($id);
        $video->img  = $new_file_name;
        if($video->save())
            return true;

        throw new GeneralException('There was a problem updating this video. Please try again.');
    }

    /**
     * @param $id
     * @return bool
     * @throws GeneralException
     */
    public function destroy($id) {
        $video = $this->findOrThrowException($id);
        if ($video->delete())
            return true;

        throw new GeneralException("There was a problem deleting this video. Please try again.");
    }

    /**
     * @param $input
     * @return mixed
     */
    private function createVideoStub($input)
    {
        $video = new Video;
        $video->title = $input['title'];
        $video->slug = $input['slug'];
        $video->url = $input['url'];
        if(isset($input['activation_date'])) $video->activation_date = parsebr($input['activation_date']);
        $video->content = $input['content'];
        if(isset($input['tags'])) $video->tags = implode(';', $input['tags']);
        if(isset($input['img'])) $video->img = $input['img'];
        $video->status = isset($input['status']) ? 1 : 0;
        return $video;

    }

}