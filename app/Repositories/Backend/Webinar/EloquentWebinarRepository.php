<?php namespace App\Repositories\Backend\Webinar;

use App\Webinar;
use App\Exceptions\GeneralException;
use Carbon\Carbon;


/**
 * Class EloquentBannerRepository
 * @package App\Repositories\Banner
 */
class EloquentWebinarRepository implements WebinarContract {


	public function __construct() {
	}

	/**
	 * @param $id
	 * @return mixed
	 * @throws GeneralException
	 */
	public function findOrThrowException($id) {
		$webinar = Webinar::withTrashed()->find($id);

		if (! is_null($webinar)) return $webinar;

		throw new GeneralException('That Webinar does not exist.');
	}

	/**
	 * @param $per_page
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getWebinarsPaginated($per_page, $title, $order_by = 'id', $sort = 'asc') {
            $query = Webinar::orderBy($order_by, $sort);

            if(!empty($title)){
                $query->where('title', 'like', '%'.$title.'%');
            }
    		return $query->paginate($per_page);
	}

    /**
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function create($input){
        $webinars = $this->createWebinarStub($input);
        if($webinars->save()) {
            return true;
        }
        throw new GeneralException('There was a problem creating this webinar. Please try again.');
    }

    /**
     * @param $id
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function update($id, $input) {
        $webinar = $this->findOrThrowException($id);

        $webinar->title = $input['title'];
        $webinar->description = $input['description'];
        $webinar->youtube_live_url = $input['youtube_live_url'];
        $webinar->date = (!empty($input['date'])) ? parsebr($input['date']) : NULL;
        $webinar->courses_id = $input['courses_id'];

        if($webinar->save()){
            return true;
        }

        throw new GeneralException('There was a problem updating this banner. Please try again.');
    }

    /**
     * @param $id
     * @return bool
     * @throws GeneralException
     */
    public function destroy($id) {
        $webinar = $this->findOrThrowException($id);
        if ($webinar->delete())
            return true;

        throw new GeneralException("There was a problem deleting this Webinar. Please try again.");
    }

    /**
     * @param $input
     * @return mixed
     */
    private function createWebinarStub($input)
    {
        $webinar = new Webinar;
        $webinar->title = $input['title'];
        $webinar->youtube_live_url = $input['youtube_live_url'];
        $webinar->courses_id = $input['courses_id'];
        $webinar->description = $input['description'];
        $webinar->date = (!empty($input['date'])) ? parsebr($input['date']) : NULL;
        return $webinar;
    }

    /**
     * @param $input
     * @return mixed
     */
    public function getAllUsersCourse($input)
    {

        return Webinar::select('webinars.title AS webinar_title',
            'webinars.description AS AS webinar_description',
            'courses.title AS course_title',
            'students.name AS student_name',
            'students.email AS student_email',
            'enrollments.date_end AS enrollment_date_end',
            'enrollments.is_active AS enrollment_is_active'
        )
            ->where('webinars.id', '=', $input['id'])
            ->join('courses', 'courses.id', '=', 'webinars.courses_id')
            ->join('enrollments', 'enrollments.course_id', '=', 'courses.id')
            ->join('users AS students', 'students.id', '=', 'enrollments.student_id')
            ->where('enrollments.is_active', '=', 1)
            ->where('enrollments.date_end', '>=', date('Y-m-d'))
            ->get();
    }
}