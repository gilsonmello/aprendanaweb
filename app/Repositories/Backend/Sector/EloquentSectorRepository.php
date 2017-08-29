<?php namespace App\Repositories\Backend\Sector;

use App\Sector;
use App\Exceptions\GeneralException;
use Carbon\Carbon;

/**
 * Class EloquentSectorRepository
 * @package App\Repositories\Sector
 */
class EloquentSectorRepository implements SectorContract {


//	public function __construct() {
//	}

	/**
	 * @param $id
	 * @return mixed
	 * @throws GeneralException
	 */
	public function findOrThrowException($id) {
		$sector = Sector::withTrashed()->find($id);

		if (! is_null($sector)) return $sector;

		throw new GeneralException('That sector does not exist.');
	}

	/**
	 * @param $per_page
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getSectorsPaginated($per_page, $order_by = 'id', $sort = 'asc') {
		return Sector::allIfOwner()->orderBy($order_by, $sort)->paginate($per_page);
	}

	/**
	 * @param $per_page
	 * @return \Illuminate\Pagination\Paginator
	 */
	public function getDeletedSectorsPaginated($per_page) {
		return Sector::allIfOwner()->onlyTrashed()->paginate($per_page);
	}

    public function getSectors(){
        return Sector::orderBy('name', 'ASC');
    }


	/**
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getAllSectors($order_by = 'name', $sort = 'asc') {
		return Sector::allIfOwner()->orderBy($order_by, $sort)->get();
	}

    public function getAllSectorsNoUsers($order_by = 'name', $sort = 'asc') {
        return Sector::orderBy($order_by, $sort)->get();
    }

    /**
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function create($input) {
        $sector = $this->createSectorStub($input);
        if($sector->save()) {

            if($input['admins'])
                $sector->users()->attach($input['admins']);
            else
                throw new GeneralException('É preciso selecionar pelo menos um administrador para o setor.');

            return $sector->id;
        }
        throw new GeneralException('There was a problem creating this sector. Please try again.');
    }

    /**
     * @param $id
     * @param $input
     * @param $admins
     * @return bool
     * @throws GeneralException
     */
    public function update($id, $input, $admins) {
        $sector = $this->findOrThrowException($id);
        if(isset($input['tags'])) $input['tags'] = implode(';', $input['tags']);

        if ($sector->update($input)) {
            $sector->name = $input['name'];
            $sector->save();

            if($admins['admins'])
                $sector->users()->sync($admins['admins']);
            else
                throw new GeneralException('É preciso selecionar pelo menos um administrador para o setor.');

            return true;
        }

        throw new GeneralException('There was a problem updating this sector. Please try again.');
    }


    /**
     * @param $id
     * @return bool
     * @throws GeneralException
     */
    public function destroy($id) {
        $sector = $this->findOrThrowException($id);
        if ($sector->delete())
            return true;

        throw new GeneralException("There was a problem deleting this sector. Please try again.");
    }

    /**
     * @param $input
     * @return mixed
     */
    private function createSectorStub($input)
    {
        $sector = new Sector;
        $sector->name = $input['name'];
        return $sector;
    }

}