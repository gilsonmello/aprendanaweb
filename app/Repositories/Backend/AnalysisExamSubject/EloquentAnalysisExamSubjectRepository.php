<?php namespace App\Repositories\Backend\AnalysisExamSubject;

use App\AnalysisExamSubject;
use App\Exceptions\GeneralException;

/**
 * Class EloquentAnalysisExamSubjectRepository
 * @package App\Repositories\AnalysisExamSubject
 */
class EloquentAnalysisExamSubjectRepository implements AnalysisExamSubjectContract {


//	public function __construct() {
//	}

	/**
	 * @param $id
	 * @return mixed
	 * @throws GeneralException
	 */
	public function findOrThrowException($id) {
		$analysisexam = AnalysisExamSubject::withTrashed()->find($id);

		if (! is_null($analysisexam)) return $analysisexam;

		throw new GeneralException('That analysisexam does not exist.');
	}

	/**
	 * @param $per_page
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getAnalysisExamSubjectsPaginated($per_page, $order_by = 'id', $sort = 'asc', $f_AnalysisExamSubjectController_title = '') {
		return AnalysisExamSubject::where('title', 'like', '%'.$f_AnalysisExamSubjectController_title.'%')->orderBy($order_by, $sort)->paginate($per_page);
	}

	/**
	 * @param $per_page
	 * @return \Illuminate\Pagination\Paginator
	 */
	public function getDeletedAnalysisExamSubjectsPaginated($per_page) {
		return AnalysisExamSubject::onlyTrashed()->paginate($per_page);
	}

	/**
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getAllAnalysisExamSubjects($order_by = 'id', $sort = 'asc') {
		return AnalysisExamSubject::orderBy($order_by, $sort)->get();
	}

    /**
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function create($input, $f_analysisexam_edit) {
        $analysisexam = $this->createAnalysisExamSubjectStub($input);

        if (( $input['subjects'][0] != null) && ($input['subjects'][0] != ''))
            $analysisexam->subject()->associate($input['subjects'][0]);

        $analysisexam->analysisExam()->associate( $f_analysisexam_edit );

        if($analysisexam->save())
            return $analysisexam;
        throw new GeneralException('There was a problem creating this analysisexam. Please try again.');
    }

    /**
     * @param $id
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function update($id, $input) {
        $analysisexam = $this->findOrThrowException($id);

        $analysisexam->count = $input['count'];
        $analysisexam->save();

        return $analysisexam;

        throw new GeneralException('There was a problem updating this analysisexam. Please try again.');
    }

    /**
     * @param $id
     * @return bool
     * @throws GeneralException
     */
    public function destroy($id) {
        $analysisexam = $this->findOrThrowException($id);
        if ($analysisexam->delete())
            return true;

        throw new GeneralException("There was a problem deleting this analysisexam. Please try again.");
    }

    /**
     * @param $input
     * @return mixed
     */
    private function createAnalysisExamSubjectStub($input)
    {

        $analysisexam = new AnalysisExamSubject;
        $analysisexam->count = $input['count'];

        return $analysisexam;
    }

    public function add($subject_id, $count, $analysisexam_id){
        $analysisexamsubject= new AnalysisExamSubject();
        $analysisexamsubject->subject_id = $subject_id;
        $analysisexamsubject->analysis_exam_id = $analysisexam_id;
        $analysisexamsubject->count = $count;
        $analysisexamsubject->save();
    }

}