<?php namespace App\Repositories\Backend\Configuration;

use App\Configuration;
use App\Exceptions\GeneralException;

/**
 * Class EloquentConfigurationRepository
 * @package App\Repositories\configurations
 */
class EloquentConfigurationRepository implements ConfigurationContract {


//	public function __construct() {
//	}

	/**
	 * @param $id
	 * @return mixed
	 * @throws GeneralException
	 */
	public function findOrThrowException($id = 1) {
		$configuration = Configuration::withTrashed()->find($id);

		if (! is_null($configuration)) return $configuration;

		throw new GeneralException('That configurationurations does not exist.');
	}

	/**
	 * @param $per_page
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
    public function getConfigurationsPaginated($per_page, $status = 1, $order_by = 'id', $sort = 'asc') {
        //return configurations::orderBy($order_by, $sort)->paginate($per_page);
    }


	/**
	 * @param $per_page
	 * @return \Illuminate\Pagination\Paginator
	 */
	public function getDeletedConfigurationsPaginated($per_page) {
		//return configurations::onlyTrashed()->paginate($per_page);
	}

	/**
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getAllConfigurations($order_by = 'id', $sort = 'asc') {
		//return configurations::orderBy($order_by, $sort)->get();
	}

    /**
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function create($input) {
//        $configuration = $this->createConfigurationStub($input);
//        if($configuration->save())
//            return true;
        throw new GeneralException('There was a problem creating this configurations. Please try again.');
    }

    /**
     * @param $id
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function update($input) {
        $configuration = $this->findOrThrowException(1);
        if ($configuration == null){
            $configuration = new Configuration;
            $configuration->percentage_count_video_view = 65;
            $configuration->video_views = 2;
            $configuration->percetage_share_teachers = 10;
            $configuration->operational_cost = 0;
            $configuration->user_changed_id = 1;
            $configuration->taxes = 0;
            $configuration->payment_fee = 0;
            isset($configuration->cart_recovery) ? $configuration->cart_recovery : NULL;
            $configuration->save();
        }

        if ($configuration->update($input)) {
            $configuration->user_changed_id = auth()->user()->id;
            $configuration->save();

            return true;
        }

        throw new GeneralException('There was a problem updating this configurations. Please try again.');
    }

    /**
     * @param $id
     * @return bool
     * @throws GeneralException
     */
    public function destroy($id) {
//        $configuration = $this->findOrThrowException($id);
//        if ($configuration->delete())
//            return true;

        throw new GeneralException("There was a problem deleting this configurations. Please try again.");
    }

    /**
     * @param $input
     * @return mixed
     */
    private function createConfigurationStub($input)
    {
//        $configuration = new configurations;
//        return $configuration;
    }

}