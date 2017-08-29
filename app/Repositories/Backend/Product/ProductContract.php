<?php namespace App\Repositories\Backend\Product;

/**
 * Interface ProductContract
 * @package App\Repositories\Product
 */
interface ProductContract {

        /**
         * Função para retornar todas as cidades
         * @return mixed
         */
        public function getAllSuppliers();

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
        public function getProductsPaginated($per_page, $order_by = 'id', $sort = 'asc', $product_name = '');


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
