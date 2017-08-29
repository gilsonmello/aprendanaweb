<?php namespace App\Repositories\Backend\TeacherStatement;

use App\TeacherStatement;
use App\Exceptions\GeneralException;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


/**
 * Class EloquentArticleRepository
 * @package App\Repositories\Article
 */
class EloquentTeacherStatementRepository implements TeacherStatementContract {


//	public function __construct() {
//	}

	/**
	 * @param $id
	 * @return mixed
	 * @throws GeneralException
	 */
	public function findOrThrowException($id) {
		$teacherStatement = TeacherStatement::withTrashed()->find($id);

		if (! is_null($teacherStatement)) return $teacherStatement;

		throw new GeneralException('That teacherStatement does not exist.');
	}

	/**
	 * @param $per_page
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getTeacherStatementsPaginated($per_page, $order_by = 'id', $sort = 'asc') {
		return TeacherStatement::orderBy($order_by, $sort)->paginate($per_page);
	}

    public function getTeacherStatementsWithBalancePaginated($per_page, $date_begin, $date_end, $user, $order_by = 'date', $sort = 'asc') {

    }

    public function getTeacherStatementsWithBalance($date_begin, $date_end, $user, $order_by = 'date', $sort = 'asc') {
        $query = TeacherStatement::whereNotNull('id');
        if (isset($date_begin) && $date_begin != "")
            $query->where('date', '>=', parsebr($date_begin));
        if (isset($date_begin) && $date_end != "")
            $query->where('date', '<', parsebr($date_end)->addDay());
        $query->where('user_teacher_id', '=', $user);
        $teacherStatements = $query->orderBy('date', 'asc')->orderBy('id', 'asc')->get();

        $balance = $this->getTeacherStatementBalance($date_begin, $user);

        foreach ($teacherStatements as $teacherstatement){
            $balance = $balance + $teacherstatement->value;
            $teacherstatement->balance = $balance;
        }

        return $teacherStatements;
	}

    public function getTeacherStatementsForPayment($datebegin, $dateend = null) {
        if ($dateend == null) $dateend = $datebegin;

        $query = TeacherStatement::whereNotNull('order_id');
        $query->where('date', '>=', parsebr($datebegin));
        $query->where('date', '<', parsebr($dateend)->addDay());
        $teacherStatements = $query->get();

        return $teacherStatements;
    }

    public function deleteTeacherStatementsFromOrder($datebegin, $dateend = null) {
        if ($dateend == null) $dateend = $datebegin;

        \DB::statement('delete from teacher_statements where value > 0 and date_order >= :datebegin and date_order < :dateend ', array('datebegin' => parsebr($datebegin), 'dateend' => parsebr($dateend)->addDay()));
    }


    public function getTeacherStatementBalance($date_balance, $user){
        if (!isset($user) || $user === null || $user === "") {

        }
        if (!isset($date_balance) || $date_balance === null || $date_balance === "") {
            return 0;
        }

        return DB::table('teacher_statements')->where('user_teacher_id', '=', $user)->whereNull('deleted_at')->where('date', '<', parsebr($date_balance))->sum('value');
    }


	/**
	 * @param $per_page
	 * @return \Illuminate\Pagination\Paginator
	 */
	public function getDeletedTeacherStatementsPaginated($per_page) {
		return TeacherStatement::onlyTrashed()->paginate($per_page);
	}

	/**
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getAllTeacherStatements($order_by = 'id', $sort = 'asc') {
		return TeacherStatement::orderBy($order_by, $sort)->get();
	}

    /**
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function create($input, $user) {
        $teacherStatement = $this->createTeacherStatementStub($input);

        if (isset($user) && $user != ""){
            $teacherStatement->user_teacher_id = $user;
        } else {
            return;
        }

        $dateBalance = parsebr($input['date']); ;

        $balance = $this->getTeacherStatementBalance( format_datebr($dateBalance->addDays(1)), $user );

        if (($teacherStatement->anticipation != 1) && (($balance + $teacherStatement->value) < 0)){
            throw new GeneralException('Saldo indisponível para a data informada.');
        }

        if ( parsebr($input['date']) > Carbon::now()){
            throw new GeneralException('Data maior do que a data atual.');
        }

        if($teacherStatement->save())
            return true;
        throw new GeneralException('There was a problem creating this teacherStatement. Please try again.');
    }

    /**
     * @param $id
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function update($id, $input) {
        $teacherStatement = $this->findOrThrowException($id);

        if ($teacherStatement->update($input)) {
            $teacherStatement->save();

            return true;
        }

        throw new GeneralException('There was a problem updating this teacherStatement. Please try again.');
    }

    /**
     * @param $id
     * @return bool
     * @throws GeneralException
     */
    public function destroy($id) {
        $teacherStatement = $this->findOrThrowException($id);
        if ($teacherStatement->delete())
            return true;

        throw new GeneralException("There was a problem deleting this teacherStatement. Please try again.");
    }

    /**
     * @param $input
     * @return mixed
     */
    private function createTeacherStatementStub($input)
    {
        $teacherStatement = new TeacherStatement;
        $teacherStatement->value = parsemoneybr($input['value']) * -1;
        $teacherStatement->date = parsebr($input['date']);
        $teacherStatement->anticipation = isset($input['anticipation']) ? 1 : 0;
        return $teacherStatement;
    }



}