<?php namespace App\Repositories\Backend\Subsection;

use App\Subsection;
use App\Exceptions\GeneralException;

/**
 * Class EloquentSubsectionRepository
 * @package App\Repositories\Subsection
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
	 * @param $per_page
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getSubsectionsPaginated($per_page, $order_by = 'name', $sort = 'asc') {
		return Subsection::orderBy('section_id', 'asc')->orderBy($order_by, $sort)->paginate($per_page);
	}

	/**
	 * @param $per_page
	 * @return \Illuminate\Pagination\Paginator
	 */
	public function getDeletedSubsectionsPaginated($per_page) {
		return Subsection::onlyTrashed()->paginate($per_page);
	}

	/**
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getAllSubsections($order_by = 'id', $sort = 'asc') {
		return Subsection::orderBy($order_by, $sort)->get();
	}

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getSubsectionsSelect($order_by = 'id', $sort = 'asc') {
        $subsections = Subsection::orderBy($order_by, $sort)->get();

        $return = [];
        foreach ($subsections as $subsection) {
            $return[$subsection->id] = $subsection->section->name . ' - ' . $subsection->name;
        }
        return $return;
    }

    /**
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function create($input) {

        $subsection = $this->createSubsectionStub($input);
        $subsection->section()->associate($input['sections'][0]);
        if($subsection->save()) {
            return true;
        }
        throw new GeneralException('There was a problem creating this subsection. Please try again.');
    }

    /**
     * @param $id
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function update($id, $input) {

        $subsection = $this->findOrThrowException($id);
        $subsection->section()->associate($input['sections'][0]);
        unset($input['sections']);
        if ($subsection->update($input)) {

            $subsection->name  = $input['name'];
            $subsection->save();

            return true;
        }

        throw new GeneralException('There was a problem updating this subsection. Please try again.');
    }

    /**
     * @param $id
     * @return bool
     * @throws GeneralException
     */
    public function destroy($id) {
        $subsection = $this->findOrThrowException($id);
        if ($subsection->delete())
            return true;

        throw new GeneralException("There was a problem deleting this subsection. Please try again.");
    }

    /**
     * @param $input
     * @return mixed
     */
    private function createSubsectionStub($input)
    {

        $subsection = new Subsection;
        $subsection->name = $input['name'];
        $subsection->slug = $input['slug'];
        return $subsection;
    }

}