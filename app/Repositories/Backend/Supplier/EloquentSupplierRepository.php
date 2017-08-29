<?php

namespace App\Repositories\Backend\Supplier;

use App\Supplier;
use App\City;
use App\State;
use App\Country;
use App\Exceptions\GeneralException;
use Carbon\Carbon;

/**
 * Class EloquentNewsRepository
 * @package App\Repositories\News
 */
class EloquentSupplierRepository implements SupplierContract {

    public function __construct() {
        
    }

    /**
     * Função para retornar todas as cidades
     * @return mixed
     */
    public function getAllCities() {
        return City::cities();
    }

    /**
     * Função para retornar todos os estados
     * @return mixed
     */
    public function getAllStates() {
        return State::states();
    }

    /**
     * Função para retornar todos os países
     * @return mixed
     */
    public function getAllCountries() {
        return Country::countries();
    }

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function findOrThrowException($id) {
        $supplier = Supplier::withTrashed()->find($id);

        if (!is_null($supplier))
            return $supplier;

        throw new GeneralException('Fornecedor inexistente');
    }

    /**
     * @param $per_page
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllSuppliersPaginated($per_page, $order_by = 'id', $sort = 'asc', $f_NewsController_title = '') {
        return Supplier::where('company_name', 'like', '%' . $f_NewsController_title . '%')->orderBy($order_by, $sort)->paginate($per_page);
    }

    /**
     * @param $per_page
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getNewsPaginated($per_page, $order_by = 'id', $sort = 'asc', $f_NewsController_title = '') {
        return News::whereNull('domain_id')->where('title', 'like', '%' . $f_NewsController_title . '%')->orderBy($order_by, $sort)->paginate($per_page);
    }

    /**
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function create($input) {
        $supplier = $this->createSupplierStub($input);
        if ($supplier->save()) {
            return true;
        }
        throw new GeneralException('There was a problem creating this supplier. Please try again.');
    }

    /**
     * @param $input
     * @return mixed
     */
    private function createSupplierStub($input) {

        //Instância de um novo fornecedor
        $supplier = new Supplier;

        //Nome do fornecedor
        $supplier->company_name = $input['company_name'];

        //Contato do fornecedor
        $supplier->contact = (isset($input['contact']) && !empty($input['contact'])) ? $input['contact'] : NULL;

        //Telefone do fornecedor
        $supplier->fone = (isset($input['fone']) && !empty($input['fone'])) ? $input['fone'] : NULL;

        //Cidade do fornecedor
        $supplier->city_id = (isset($input['city_id']) && !empty($input['city_id'])) ? $input['city_id'] : NULL;

        //Estado do fornecedor
        $supplier->state_id = (isset($input['state_id']) && !empty($input['state_id'])) ? $input['state_id'] : NULL;

        //País do fornecedor
        $supplier->country_id = (isset($input['country_id']) && !empty($input['country_id'])) ? $input['country_id'] : NULL;

        return $supplier;
    }

    /**
     * @param $id
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function update($id, $input) {

        //Fazendo busca do registro pelo ID
        $supplier = $this->findOrThrowException($id);

        //Nome do fornecedor
        $supplier->company_name = $input['company_name'];

        //Contato do fornecedor
        $supplier->contact = (isset($input['contact']) && !empty($input['contact'])) ? $input['contact'] : NULL;

        //Telefone do fornecedor
        $supplier->fone = (isset($input['fone']) && !empty($input['fone'])) ? $input['fone'] : NULL;

        //Cidade do fornecedor
        $supplier->city_id = (isset($input['city_id']) && !empty($input['city_id'])) ? $input['city_id'] : NULL;

        //Estado do fornecedor
        $supplier->state_id = (isset($input['state_id']) && !empty($input['state_id'])) ? $input['state_id'] : NULL;

        //País do fornecedor
        $supplier->country_id = (isset($input['country_id']) && !empty($input['country_id'])) ? $input['country_id'] : NULL;

        //Atualizando registro
        if ($supplier->save()) {
            return true;
        }

        throw new GeneralException('There was a problem updating this fornecedor. Please try again.');
    }

    /**
     * @param $id
     * @return bool
     * @throws GeneralException
     */
    public function destroy($id) {
        $supplier = $this->findOrThrowException($id);
        if ($supplier->delete())
            return true;

        throw new GeneralException("There was a problem deleting this fornecedor. Please try again.");
    }

}
