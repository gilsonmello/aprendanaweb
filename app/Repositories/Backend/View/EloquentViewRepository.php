<?php namespace App\Repositories\Backend\View;

use App\View;
use App\Exceptions\GeneralException;

/**
 * Class EloquentViewRepository
 * @package App\Repositories\View
 */
class EloquentViewRepository implements ViewContract {


//	public function __construct() {
//	}

	/**
	 * @param $id
	 * @return mixed
	 * @throws GeneralException
	 */
	public function findOrThrowException($id) {
		$view = View::withTrashed()->find($id);

		if (! is_null($view)) return $view;

		throw new GeneralException('That views does not exist.');
	}

    public function getViewCoursePerStudent($f_ViewController_student_id, $f_ViewController_enrollment_id) {
        return View::
            where('enrollment_id', '=', $f_ViewController_enrollment_id)
            ->select('view.*')
            ->join('contents', 'contents.id', '=', 'view.content_id')
            ->join('lessons', 'lessons.id', '=', 'contents.lesson_id')
            ->join('modules', 'modules.id', '=', 'lessons.module_id')
            ->orderBy('modules.name', 'asc')
            ->orderBy('lessons.sequence', 'asc')
            ->orderBy('contents.sequence', 'asc')
            ->get();
    }

    public function getViewModulePerStudent($f_ViewController_student_id, $f_ViewController_enrollment_id) {
        return View::
            where('enrollment_id', '=', $f_ViewController_enrollment_id)
            ->select('view.*')
            ->join('contents', 'contents.id', '=', 'view.content_id')
            ->join('lessons', 'lessons.id', '=', 'contents.lesson_id')
            ->orderBy('lessons.sequence', 'asc')
            ->orderBy('contents.sequence', 'asc')
            ->get();
    }

    public function getViewLessonPerStudent($f_ViewController_student_id, $f_ViewController_enrollment_id) {
        return View::
            join('contents', 'contents.id', '=', 'view.content_id')
            ->select('view.*')
            ->where('enrollment_id', '=', $f_ViewController_enrollment_id)
            ->orderBy('contents.sequence', 'asc')
            ->get();
    }


    /**
	 * @param $per_page
	 * @return \Illuminate\Pagination\Paginator
	 */
	public function getDeletedViewsPaginated($per_page) {
		return View::onlyTrashed()->paginate($per_page);
	}

	/**
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getAllViews($order_by = 'id', $sort = 'asc') {
		return View::orderBy($order_by, $sort)->get();
	}

    /**
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function create($input) {
        $view = $this->createViewStub($input);
        if($view->save())
            return true;
        throw new GeneralException('There was a problem creating this views. Please try again.');
    }

    /**
     * @param $id
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function update($id, $input) {
        $view = $this->findOrThrowException($id);

        if ($view->update($input)) {
            //$view->email  = $input['email'];
            $view->save();

            return true;
        }

        throw new GeneralException('There was a problem updating this views. Please try again.');
    }

    /**
     * @param $id
     * @return bool
     * @throws GeneralException
     */
    public function destroy($id) {
        $view = $this->findOrThrowException($id);
        if ($view->delete())
            return true;

        throw new GeneralException("There was a problem deleting this views. Please try again.");
    }

    /**
     * @param $input
     * @return mixed
     */
    private function createViewStub($input)
    {
        $view = new View;
		//$view->email  = $input['email'];
        return $view;
    }



}