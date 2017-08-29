<?php namespace App\Repositories\Frontend\Subsection;

use App\Subsection;
use App\Exceptions\GeneralException;

/**
 * Class EloquentSectionRepository
 * @package App\Repositories\Section
 */
class EloquentSubsectionRepository implements SubsectionContract {


//	public function __construct() {
//	}

	/**
	 * @param $id
	 * @return mixed
	 * @throws GeneralException
	 */
	public function findOrThrowException($id) {
		$subsection = Subsection::withTrashed()->find($id);

		if (! is_null($subsection)) return $subsection;

		throw new GeneralException('That subsection does not exist.');
	}

    /**
     * @param $slug
     * @return mixed
     * @throws GeneralException
     */
    public function findBySlug($slug) {
        $subsection = Subsection::where('slug', $slug)->first();
        if (! is_null($subsection) && $subsection->section->active == "1") return $subsection;
    }

	public function getAllSubsectionsBySection($section_id, $order_by = 'id', $sort = 'asc') {
		return Subsection::where('section_id',$section_id)->orderBy($order_by, $sort)->get();
	}

}