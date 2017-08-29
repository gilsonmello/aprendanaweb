<?php

namespace App\Repositories\Backend\Supplier;

/**
 * Interface UserContract
 * @package App\Repositories\News
 */
interface SupplierContract {

    /**
     * Função para retornar todas as cidades
     * @return mixed
     */
    public function getAllCities();

    /**
     * Função para retornar todos os estados
     * @return mixed
     */
    public function getAllStates();

    /**
     * Função para retornar todos os países
     * @return mixed
     */
    public function getAllCountries();

    /**
     * @param $id
     * @return mixed
     */
    public function findOrThrowException($id);

    /**
     * @param $per_page
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllSuppliersPaginated($per_page, $order_by = 'id', $sort = 'asc', $f_NewsController_title = '');

    /**
     * @param $per_page
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getNewsPaginated($per_page, $order_by = 'id', $sort = 'asc', $f_NewsController_title = '');

    /**
     * @param $input
     * @return mixed
     */
    public function create($input);

    /**
     * @param $id
     * @param $input
     * @return mixed
     */
    public function update($id, $input);

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id);
}
