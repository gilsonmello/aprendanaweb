<?php namespace App\Repositories\Backend\State;

use App\State;
use App\Exceptions\GeneralException;

/**
 * Class EloquentStateRepository
 * @package App\Repositories\State
 */
class EloquentStateRepository implements StateContract {


//	public function __construct() {
//	}

	/**
	 * @param $id
	 * @return mixed
	 * @throws GeneralException
	 */
	public function findOrThrowException($id) {
		$state = State::withTrashed()->find($id);

		if (! is_null($state)) return $state;

		throw new GeneralException('That states does not exist.');
	}

	/**
	 * @param $per_page
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getStatesPaginated($per_page, $order_by = 'id', $sort = 'asc') {
		return State::orderBy($order_by, $sort)->paginate($per_page);
	}

	/**
	 * @param $per_page
	 * @return \Illuminate\Pagination\Paginator
	 */
	public function getDeletedStatesPaginated($per_page) {
		return State::onlyTrashed()->paginate($per_page);
	}

	/**
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getAllStates($order_by = 'id', $sort = 'asc') {
		return State::orderBy($order_by, $sort)->get();
	}

    public function selectStates($term = '', $order_by = 'name', $sort = 'asc') {
        return State::where('name', 'like', $term.'%')->orderBy($order_by, $sort)->get();
    }
    
    /**
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function create($input) {
        $state = $this->createStateStub($input);
        if($state->save())
            return true;
        throw new GeneralException('There was a problem creating this states. Please try again.');
    }

    /**
     * @param $id
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function update($id, $input) {
        $state = $this->findOrThrowException($id);

        if ($state->update($input)) {
            $state->name = $input['name'];
            $state->save();

            return true;
        }

        throw new GeneralException('There was a problem updating this states. Please try again.');
    }

    /**
     * @param $id
     * @return bool
     * @throws GeneralException
     */
    public function destroy($id) {
        $state = $this->findOrThrowException($id);
        if ($state->delete())
            return true;

        throw new GeneralException("There was a problem deleting this states. Please try again.");
    }

    /**
     * @param $input
     * @return mixed
     */
    private function createStateStub($input)
    {
        $state = new State;
		$state->name  = $input['name'];
		$state->state_id = 1;
        return $state;
    }

}