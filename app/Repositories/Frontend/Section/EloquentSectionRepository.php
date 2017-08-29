<?php namespace App\Repositories\Frontend\Section;

use App\Section;
use App\Exceptions\GeneralException;

/**
 * Class EloquentSectionRepository
 * @package App\Repositories\Section
 */
class EloquentSectionRepository implements SectionContract {


//	public function __construct() {
//	}

	/**
	 * @param $id
	 * @return mixed
	 * @throws GeneralException
	 */
	public function findOrThrowException($id) {
		$section = Section::withTrashed()->find($id);

		if (! is_null($section)) return $section;

		throw new GeneralException('That section does not exist.');
	}

    /**
     * @param $slug
     * @return mixed
     * @throws GeneralException
     */
    public function findBySlug($slug) {
        $section = Section::where('slug', $slug)->where('active', '=', 1)->first();
        if (! is_null($section)) return $section;
    }

	/**
	 * @param $per_page
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getSectionsPaginated($per_page, $order_by = 'id', $sort = 'asc') {
		return Section::orderBy($order_by, $sort)->paginate($per_page);
	}


	public function getSectionsPaginatedWithImg($per_page, $order_by = 'id', $sort = 'asc') {
		return Section::orderBy($order_by, $sort)->where('active',1)->whereNotNull('addimg')->paginate($per_page);
	}

	/**
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getAllSections($order_by = 'id', $sort = 'asc') {
		return Section::orderBy($order_by, $sort)->get();
	}

}