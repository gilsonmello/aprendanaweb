<?php namespace App\Repositories\Backend\Source;

use App\Source;
use App\Exceptions\GeneralException;

/**
 * Class EloquentSourceRepository
 * @package App\Repositories\Source
 */
class EloquentSourceRepository implements SourceContract {


//	public function __construct() {
//	}

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function findOrThrowException($id) {
        $source = Source::withTrashed()->find($id);

        if (! is_null($source)) return $source;

        throw new GeneralException('That source does not exist.');
    }

    /**
     * @param $per_page
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */

    public function getSourcesPaginated($per_page, $order_by = 'id', $sort = 'asc', $f_SourceController_name = '') {
        return Source::where('name', 'like', '%'.$f_SourceController_name.'%')->orderBy($order_by, $sort)->paginate($per_page);
    }

    /**
     * @param $per_page
     * @return \Illuminate\Pagination\Paginator
     */
    public function getDeletedSourcesPaginated($per_page) {
        return Source::onlyTrashed()->paginate($per_page);
    }

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllSources($order_by = 'id', $sort = 'asc') {
        return Source::orderBy($order_by, $sort)->get();
    }

    /**
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function create($input) {
        $source = $this->createSourceStub($input);
        if($source->save())
            return $source;
        throw new GeneralException('There was a problem creating this source. Please try again.');
    }

    /**
     * @param $id
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function update($id, $input) {
        $source = $this->findOrThrowException($id);


        if ($source->update($input)) {
            $source->save();

            return $source;
        }

        throw new GeneralException('There was a problem updating this source. Please try again.');
    }

    /**
     * @param $id
     * @return bool
     * @throws GeneralException
     */
    public function destroy($id) {
        $source = $this->findOrThrowException($id);
        if ($source->delete())
            return true;

        throw new GeneralException("There was a problem deleting this source. Please try again.");
    }

    /**
     * @param $input
     * @return mixed
     */
    private function createSourceStub($input)
    {

        $source = new Source;
        $source->name = $input['name'];
        $source->description = $input['description'];
        return $source;
    }

}