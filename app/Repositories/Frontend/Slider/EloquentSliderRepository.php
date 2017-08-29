<?php namespace App\Repositories\Frontend\Slider;

use App\Slider;
use App\Exceptions\GeneralException;
use Carbon\Carbon;


/**
 * Class EloquentSliderRepository
 * @package App\Repositories\Slider
 */
class EloquentSliderRepository implements SliderContract {


	public function __construct() {
	}

	/**
	 * @param $id
	 * @return mixed
	 * @throws GeneralException
	 */
	public function findOrThrowException($id) {
		$slider = Slider::withTrashed()->find($id);

		if (! is_null($slider)) return $slider;

		throw new GeneralException('That slider does not exist.');
	}

	/**
	 * @param $per_page
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getSlidersPaginated($per_page, $order_by = 'id', $sort = 'asc', $f_SliderController_title = '') {
		return Slider::orderBy($order_by, $sort)->paginate($per_page);
	}

	/**
	 * @param $per_page
	 * @return \Illuminate\Pagination\Paginator
	 */
	public function getDeletedSlidersPaginated($per_page) {
		return Slider::onlyTrashed()->paginate($per_page);
	}

	/**
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getAllSliders($order_by = 'id', $sort = 'asc') {
		return Slider::orderBy($order_by, $sort)->get();
	}

    /**
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function create($input) {
        $slider = $this->createSliderStub($input);
        if($slider->save()) {
            return $slider;
        }
        throw new GeneralException('There was a problem creating this slider. Please try again.');
    }

    /**
     * @param $id
     * @param $input
     * @param $teachers
     * @return bool
     * @throws GeneralException
     */
    public function update($id, $input) {
        $slider = $this->findOrThrowException($id);

        if ($slider->update($input)) {
            $slider->name = $input['name'];
            $slider->url = $input['url'];
            $slider->orientation   = $input['orientation'];
            $slider->save();

            return $slider;
        }

        throw new GeneralException('There was a problem updating this slider. Please try again.');
    }

    /**
     * @param $id
     * @param $new_file_name
     * @return bool
     * @throws GeneralException
     */
    public function updateImg($id, $new_file_name) {
        $slider = $this->findOrThrowException($id);
        $slider->img  = $new_file_name;
        if($slider->save())
            return true;

        throw new GeneralException('There was a problem updating this slider. Please try again.');
    }

    /**
     * @param $id
     * @return bool
     * @throws GeneralException
     */
    public function destroy($id) {
        $slider = $this->findOrThrowException($id);
        if ($slider->delete())
            return true;

        throw new GeneralException("There was a problem deleting this slider. Please try again.");
    }

    /**
     * @param $input
     * @return mixed
     */
    private function createSliderStub($input)
    {
        $slider = new Slider;
        $slider->name = $input['name'];
        $slider->url = $input['url'];
        $slider->orientation   = $input['orientation'];
        if(isset($input['img'])) $slider->img = $input['img'];
        return $slider;
    }

}