<?php namespace App\Repositories\Backend\AnalysisExam;

use App\AnalysisExam;
use App\Exceptions\GeneralException;

/**
 * Class EloquentAnalysisExamRepository
 * @package App\Repositories\AnalysisExam
 */
class EloquentAnalysisExamRepository implements AnalysisExamContract {


//	public function __construct() {
//	}

	/**
	 * @param $id
	 * @return mixed
	 * @throws GeneralException
	 */
	public function findOrThrowException($id) {
		$analysisexam = AnalysisExam::withTrashed()->find($id);

		if (! is_null($analysisexam)) return $analysisexam;

		throw new GeneralException('That analysisexam does not exist.');
	}

	/**
	 * @param $per_page
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getAnalysisExamsPaginated($per_page, $order_by = 'id', $sort = 'asc', $f_AnalysisExamController_title = '') {
		return AnalysisExam::where('title', 'like', '%'.$f_AnalysisExamController_title.'%')->orderBy($order_by, $sort)->paginate($per_page);
	}

	/**
	 * @param $per_page
	 * @return \Illuminate\Pagination\Paginator
	 */
	public function getDeletedAnalysisExamsPaginated($per_page) {
		return AnalysisExam::onlyTrashed()->paginate($per_page);
	}

	/**
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getAllAnalysisExams($order_by = 'id', $sort = 'asc') {
		return AnalysisExam::orderBy($order_by, $sort)->get();
	}

    /**
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function create($input) {
        $analysisexam = $this->createAnalysisExamStub($input);

        if (( $input['sources'][0] != null) && ($input['sources'][0] != ''))
            $analysisexam->source()->associate($input['sources'][0]);

        if (( $input['institutions'][0] != null) && ($input['institutions'][0] != ''))
            $analysisexam->institution()->associate($input['institutions'][0]);

        if (( $input['offices'][0] != null) && ($input['offices'][0] != ''))
            $analysisexam->office()->associate($input['offices'][0]);

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

        if (( $input['sources'][0] != null) && ($input['sources'][0] != ''))
            $analysisexam->source()->associate($input['sources'][0]);

        if (( $input['institutions'][0] != null) && ($input['institutions'][0] != ''))
            $analysisexam->institution()->associate($input['institutions'][0]);

        if (( $input['offices'][0] != null) && ($input['offices'][0] != ''))
            $analysisexam->office()->associate($input['offices'][0]);

            $analysisexam->title = $input['title'];
            $analysisexam->acronym = $input['acronym'];
            if(isset($input['date'])) $analysisexam->date = parsebr($input['date']);
            if(isset($input['date_result'])) $analysisexam->date_result = parsebr($input['date_result']);
            $analysisexam->is_active = isset($input['is_active']) ? 1 : 0;
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
    private function createAnalysisExamStub($input)
    {

        $analysisexam = new AnalysisExam;
        $analysisexam->title = $input['title'];
        $analysisexam->acronym = $input['acronym'];
        if(isset($input['date'])) $analysisexam->date = parsebr($input['date']);
        if(isset($input['date_result'])) $analysisexam->date_result = parsebr($input['date_result']);
        $analysisexam->is_active = isset($input['is_active']) ? 1 : 0;

        return $analysisexam;
    }

}