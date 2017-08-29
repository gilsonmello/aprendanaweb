<?php namespace App\Repositories\Backend\Analysis;

use App\Analysis;
use App\Exceptions\GeneralException;

/**
 * Class EloquentAnalysisRepository
 * @package App\Repositories\Analysis
 */
class EloquentAnalysisRepository implements AnalysisContract {


//	public function __construct() {
//	}

	/**
	 * @param $id
	 * @return mixed
	 * @throws GeneralException
	 */
	public function findOrThrowException($id) {
		$analysis = Analysis::withTrashed()->find($id);

		if (! is_null($analysis)) return $analysis;

		throw new GeneralException('That analysis does not exist.');
	}

	/**
	 * @param $per_page
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getAnalysissPaginated($per_page, $order_by = 'id', $sort = 'asc', $f_AnalysisController_title = '') {
		return Analysis::where('title', 'like', '%'.$f_AnalysisController_title.'%')->orderBy($order_by, $sort)->paginate($per_page);
	}

	/**
	 * @param $per_page
	 * @return \Illuminate\Pagination\Paginator
	 */
	public function getDeletedAnalysissPaginated($per_page) {
		return Analysis::onlyTrashed()->paginate($per_page);
	}

	/**
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getAllAnalysiss($order_by = 'id', $sort = 'asc') {
		return Analysis::orderBy($order_by, $sort)->get();
	}

    /**
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function create($input) {
        $analysis = $this->createAnalysisStub($input);

        if (( $input['subjects'][0] != null) && ($input['subjects'][0] != ''))
            $analysis->subject()->associate($input['subjects'][0]);
        else
            throw new GeneralException('Informe a disciplina.');

        if (( $input['analysisexamgroups'][0] != null) && ($input['analysisexamgroups'][0] != ''))
            $analysis->analysisExamGroup()->associate($input['analysisexamgroups'][0]);
        else
            throw new GeneralException('Informe o grupo de provas.');

        if($analysis->save())
            return $analysis;
        throw new GeneralException('There was a problem creating this analysis. Please try again.');
    }

    /**
     * @param $id
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function update($id, $input) {
        $analysis = $this->findOrThrowException($id);


        if ($analysis->update($input)) {
            $analysis->save();

            return $analysis;
        }

        throw new GeneralException('There was a problem updating this analysis. Please try again.');
    }

    /**
     * @param $id
     * @return bool
     * @throws GeneralException
     */
    public function destroy($id) {
        $analysis = $this->findOrThrowException($id);
        if ($analysis->delete())
            return true;

        throw new GeneralException("There was a problem deleting this analysis. Please try again.");
    }

    /**
     * @param $input
     * @return mixed
     */
    private function createAnalysisStub($input)
    {

        $analysis = new Analysis;
        $analysis->title = $input['title'];
        $analysis->intro_page = $input['into_page'];
        $analysis->intro_text = $input['intro_text'];
        $analysis->conclusion_text = $input['conclusion_text'];

        return $analysis;
    }

}