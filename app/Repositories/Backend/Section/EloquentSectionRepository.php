<?php namespace App\Repositories\Backend\Section;

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
	 * @param $per_page
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getSectionsPaginated($per_page, $order_by = 'id', $sort = 'asc') {
		return Section::orderBy($order_by, $sort)->paginate($per_page);
	}

	/**
	 * @param $per_page
	 * @return \Illuminate\Pagination\Paginator
	 */
	public function getDeletedSectionsPaginated($per_page) {
		return Section::onlyTrashed()->paginate($per_page);
	}

	/**
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getAllSections($order_by = 'id', $sort = 'asc') {
		return Section::orderBy($order_by, $sort)->get();
	}

    /**
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function create($input) {
        $section = $this->createSectionStub($input);
        if($section->save())
            return $section;
        throw new GeneralException('There was a problem creating this section. Please try again.');
    }

    /**
     * @param $id
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function update($id, $input) {
        $section = $this->findOrThrowException($id);


        if ($section->update($input)) {
            $section->name  = $input['name'];
            $section->sequence = $input['sequence'];
            $section->active = isset($input['active']) ? 1 : 0;
            if(isset($input['addimg'])) $section->addimg = $input['addimg'];
            if(isset($input['show_tag_cloud'])) $section->show_tag_cloud = true;
            else $section->show_tag_cloud = false;
            $section->banner  = $input['banner'];
            $section->save();

            return $section;
        }

        throw new GeneralException('There was a problem updating this section. Please try again.');
    }

    /**
     * @param $id
     * @return bool
     * @throws GeneralException
     */
    public function destroy($id) {
        $section = $this->findOrThrowException($id);
        if ($section->delete())
            return true;

        throw new GeneralException("There was a problem deleting this section. Please try again.");
    }

    /**
     * @param $input
     * @return mixed
     */
    private function createSectionStub($input)
    {

        $section = new Section;
        $section->name = $input['name'];
        $section->menu_name = $input['menu_name'];
        $section->slug = $input['slug'];
        $section->color = $input['color'];
        $section->sequence = $input['sequence'];
        $section->active = isset($input['active']) ? 1 : 0;
        if(isset($input['addimg'])) $section->addimg = $input['addimg'];
        if(isset($input['tagcloud'])) $section->show_tag_cloud = 1;
        else $section->show_tag_cloud = 0;
        $section->banner  = $input['banner'];

        return $section;
    }

    /**
     * @param $id
     * @param $new_file_name
     * @return bool
     * @throws GeneralException
     */
    public function updateImg($id, $new_file_name) {
        $section = $this->findOrThrowException($id);
        $section->addimg  = $new_file_name;
        if($section->save())
            return true;

        throw new GeneralException('There was a problem updating this video. Please try again.');
    }

}