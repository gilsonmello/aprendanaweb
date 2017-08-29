<?php namespace App\Repositories\Backend\Banner;

use App\Banner;
use App\Exceptions\GeneralException;
use Carbon\Carbon;


/**
 * Class EloquentBannerRepository
 * @package App\Repositories\Banner
 */
class EloquentBannerRepository implements BannerContract {


	public function __construct() {
	}

	/**
	 * @param $id
	 * @return mixed
	 * @throws GeneralException
	 */
	public function findOrThrowException($id) {
		$banner = Banner::withTrashed()->find($id);

		if (! is_null($banner)) return $banner;

		throw new GeneralException('That banner does not exist.');
	}

	/**
	 * @param $per_page
	 * @param string $order_by
	 * @param string $sort
     * @param string $carousel
     * @param string $is_active
	 * @return mixed
	 */
	public function getBannersPaginated($per_page, $order_by = 'order', $sort = 'asc', $carousel = '', $is_active = '') {
            $query = Banner::orderBy($order_by, $sort)
            ->orderBy('updated_at', 'DESC');
            
            if(!empty($carousel)){
                $query->whereNotNull('carousel');
            }

            if(!empty($is_active)){
                $query->where('is_active', '=', 1);
            }
    		return $query->paginate($per_page);
	}

	/**
	 * @param $per_page
	 * @return \Illuminate\Pagination\Paginator
	 */
	public function getDeletedBannersPaginated($per_page) {
		return Banner::onlyTrashed()->where('is_active', '=', 1)->paginate($per_page);
	}

	/**
	 * @param string $order_by
	 * @param string $sort
     * @param int $carousel
	 * @return mixed
	 */
	public function getAllBanners($order_by = 'order', $sort = 'asc', $carousel = 0) {
        if($carousel > 0){
            return Banner::whereNotNull('carousel')
            ->where('is_active', '=', 1)
            ->orderBy($order_by, $sort)
            ->orderBy('updated_at', 'DESC')
            ->get();
        }
		return Banner::whereNull('carousel')
        ->where('is_active', '=', 1)
        ->orderBy($order_by, $sort)
        ->orderBy('updated_at', 'DESC')
        ->get();
	}

    /**
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function create($input) {
        $banner = $this->createBannerStub($input);
        if($banner->save()) {
            return $banner;
        }
        throw new GeneralException('There was a problem creating this banner. Please try again.');
    }

    /**
     * @param $id
     * @param $input
     * @param $teachers
     * @return bool
     * @throws GeneralException
     */
    public function update($id, $input) {
        $banner = $this->findOrThrowException($id);

        $banner->name = $input['name'];
        $banner->url = $input['url'];
        $banner->carousel = (isset($input['carousel'])) ? $input['carousel'] : null;
        $banner->order = $input['order'];
        $banner->is_active = $input['is_active'];
        if (($input['exams'][0] != null) && ($input['exams'][0] != '0') && (isset($input['exams'][0]))){
            $banner->package_id = $input['exams'][0];
        } else {
            $banner->package_id = null;
        }
        if (($input['courses'][0] != null) && ($input['courses'][0] != '0') && (isset($input['courses'][0]))){
            $banner->course_id = $input['courses'][0];
        } else {
            $banner->course_id = null;
        }
        $banner->save();

        return $banner;

        throw new GeneralException('There was a problem updating this banner. Please try again.');
    }

    /**
     * @param $id
     * @param $new_file_name
     * @return bool
     * @throws GeneralException
     */
    public function updateImg($id, $new_file_name) {
        $banner = $this->findOrThrowException($id);
        $banner->img  = $new_file_name;
        if($banner->save())
            return true;

        throw new GeneralException('There was a problem updating this banner. Please try again.');
    }

    /**
     * @param $id
     * @return bool
     * @throws GeneralException
     */
    public function destroy($id) {
        $banner = $this->findOrThrowException($id);
        if ($banner->delete())
            return true;

        throw new GeneralException("There was a problem deleting this banner. Please try again.");
    }

    /**
     * @param $input
     * @return mixed
     */
    private function createBannerStub($input)
    {
        $banner = new Banner;
        $banner->name = $input['name'];
        $banner->url = $input['url'];
        $banner->carousel = (isset($input['carousel'])) ? $input['carousel'] : null;
        $banner->order = $input['order'];
        $banner->is_active = $input['is_active'];
        if (($input['exams'][0] != null) && ($input['exams'][0] != '0') && (isset($input['exams'][0]))){
            $banner->package_id = $input['exams'][0];
        } else {
            $banner->package_id = null;
        }
        if (($input['courses'][0] != null) && ($input['courses'][0] != '0') && (isset($input['courses'][0]))){
            $banner->course_id = $input['courses'][0];
        } else {
            $banner->course_id = null;
        }

        if(isset($input['img'])) $banner->img = $input['img'];
        return $banner;
    }

}