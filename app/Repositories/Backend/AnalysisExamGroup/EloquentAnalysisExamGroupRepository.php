<?php namespace App\Repositories\Backend\AnalysisExamGroup;

use App\AnalysisExamGroup;
use App\Exceptions\GeneralException;

/**
 * Class EloquentAnalysisExamGroupRepository
 * @package App\Repositories\AnalysisExamGroup
 */
class EloquentAnalysisExamGroupRepository implements AnalysisExamGroupContract {


//	public function __construct() {
//	}

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function findOrThrowException($id) {
        $analysisexamgroup = AnalysisExamGroup::withTrashed()->find($id);

        if (! is_null($analysisexamgroup)) return $analysisexamgroup;

        throw new GeneralException('That analysisexamgroup does not exist.');
    }

    /**
     * @param $per_page
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */

    public function getAnalysisExamGroupsPaginated($per_page, $order_by = 'id', $sort = 'asc', $f_AnalysisExamGroupController_title = '') {
        return AnalysisExamGroup::where('title', 'like', '%'.$f_AnalysisExamGroupController_title.'%')->orderBy($order_by, $sort)->paginate($per_page);
    }

    /**
     * @param $per_page
     * @return \Illuminate\Pagination\Paginator
     */
    public function getDeletedAnalysisExamGroupsPaginated($per_page) {
        return AnalysisExamGroup::onlyTrashed()->paginate($per_page);
    }

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllAnalysisExamGroups($order_by = 'id', $sort = 'asc') {
        return AnalysisExamGroup::orderBy($order_by, $sort)->get();
    }

    /**
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function create($input) {
        $analysisexamgroup = $this->createAnalysisExamGroupStub($input);
        if($analysisexamgroup->save())
            return $analysisexamgroup;
        throw new GeneralException('There was a problem creating this analysisexamgroup. Please try again.');
    }

    /**
     * @param $id
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function update($id, $input) {
        $analysisexamgroup = $this->findOrThrowException($id);


        if ($analysisexamgroup->update($input)) {
            $analysisexamgroup->save();

            return $analysisexamgroup;
        }

        throw new GeneralException('There was a problem updating this analysisexamgroup. Please try again.');
    }

    /**
     * @param $id
     * @return bool
     * @throws GeneralException
     */
    public function destroy($id) {
        $analysisexamgroup = $this->findOrThrowException($id);
        if ($analysisexamgroup->delete())
            return true;

        throw new GeneralException("There was a problem deleting this analysisexamgroup. Please try again.");
    }

    /**
     * @param $input
     * @return mixed
     */
    private function createAnalysisExamGroupStub($input)
    {

        $analysisexamgroup = new AnalysisExamGroup;
        $analysisexamgroup->title = $input['title'];
        return $analysisexamgroup;
    }

}