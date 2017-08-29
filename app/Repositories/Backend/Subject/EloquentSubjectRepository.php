<?php namespace App\Repositories\Backend\Subject;

use App\Subject;
use App\Exceptions\GeneralException;

/**
 * Class EloquentSubjectRepository
 * @package App\Repositories\Subject
 */
class EloquentSubjectRepository implements SubjectContract {


//	public function __construct() {
//	}

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function findOrThrowException($id) {
        $subject = Subject::withTrashed()->find($id);

        if (! is_null($subject)) return $subject;

        throw new GeneralException('That subject does not exist.');
    }

    /**
     * @param $per_page
     * @param string $order_by
     * @param string $sort
     * @param string $name
     * @param $subject_id
     * @return mixed
     */

    public function getSubjectsPaginated($per_page, $order_by = 'id', $sort = 'asc', $name = '', $subject_id = NULL) {

        $query = Subject::query();

        if(!empty($name)){
            $query->where('name', 'like', '%'.$name.'%');
        }

        if(!empty($subject_id)){
            $query->where('subject_id', '=', $subject_id);
        }

        return $query->orderBy($order_by, $sort)->paginate($per_page);
    }

    /**
     * @param $per_page
     * @return \Illuminate\Pagination\Paginator
     */
    public function getDeletedSubjectsPaginated($per_page) {
        return Subject::onlyTrashed()->paginate($per_page);
    }

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllSubjects($order_by = 'id', $sort = 'asc') {
        return Subject::orderBy($order_by, $sort)->get();
    }

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getSubjectsLastLevel($order_by = 'name', $sort = 'asc') {
        return Subject::whereNotIn('id', function ($query)
        {
            $query->select('s2.subject_id')->from('subjects as s2')->whereNotNull('s2.subject_id');
        })->orderBy($order_by, $sort)->get();
    }

    public function getSubjectsLevel1and2($order_by = 'id', $sort = 'asc'){
        return Subject::whereIn('subject_id', function ($query)
        {
            $query->select('s2.id')->from('subjects as s2')->whereNull('s2.subject_id');
        })->orWhereNull("subject_id")
        ->orderBy($order_by, $sort)->get();
    }

    public function getSubjectsLevel1($order_by = 'id', $sort = 'asc'){
        return Subject::whereNull("subject_id")->orderBy($order_by, $sort)->get();
    }

    /**
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function create($input) {
        $subject = $this->createSubjectStub($input);

        if (( $input['parents'][0] != null) && ($input['parents'][0] != ''))
            $subject->parent()->associate($input['parents'][0]);

        if($subject->save())
            return $subject;
        throw new GeneralException('There was a problem creating this subject. Please try again.');
    }

    /**
     * @param $id
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function update($id, $input) {
        $subject = $this->findOrThrowException($id);

        if (( $input['parents'][0] != null) && ($input['parents'][0] != ''))
            $subject->parent()->associate($input['parents'][0]);
        else
            $subject->subject_id = null;
        unset($input['parents']);

        if ($subject->update($input)) {
            $subject->save();

            return $subject;
        }

        throw new GeneralException('There was a problem updating this subject. Please try again.');
    }

    /**
     * @param $id
     * @return bool
     * @throws GeneralException
     */
    public function destroy($id) {
        $subject = $this->findOrThrowException($id);
        if ($subject->delete())
            return true;

        throw new GeneralException("There was a problem deleting this subject. Please try again.");
    }

    /**
     * @param $input
     * @return mixed
     */
    private function createSubjectStub($input)
    {

        $subject = new Subject;
        $subject->name = $input['name'];
        $subject->description = $input['description'];
        return $subject;
    }

    public function getSubjectByLevel($level, $order_by = 'name', $sort = 'asc',$term = null)
    {
        $subjects = null;
        if($level == 3){
            $subjects =  Subject::whereNotIn('id', function ($query)
            {
                $query->select('s2.subject_id')->from('subjects as s2')->whereNotNull('s2.subject_id');
            })->orderBy($order_by, $sort);
        }

        if($level == 2){


            $subjects =  Subject::whereNotNull('subject_id')->whereIn('id',function($query){
               $query->select('s2.subject_id')->from('subjects as s2')->whereNotNull('s2.subject_id');
            })->orderBy($order_by, $sort);


        }

        if($level == 1){

            $subjects =  Subject::whereNull('subject_id')->orderBy($order_by, $sort)->orderBy($order_by, $sort);


        }

        if($term != null){
            if($level !== 2){
            return $subjects->where('name', 'like','%' . $term.'%')->get();
            }else{
                return $subjects->where('name', 'like', '%' . $term . '%')->orWhereIn('subject_id',function($query)use($term){
                    $query->select('s3.id')->from('subjects as s3')->where('s3.name', 'like', '%' . $term.'%')->whereNotNull('s3.subject_id');

                })->get();
            }
        }else{
            return $subjects->get();
        }


    }
}