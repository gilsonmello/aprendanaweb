<?php namespace App\Repositories\Frontend\Section;

/**
 * Interface UserContract
 * @package App\Repositories\Section
 */
interface SectionContract {

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
    public function getSectionsPaginated($per_page, $order_by = 'id', $sort = 'asc');

    public function getSectionsPaginatedWithImg($per_page, $order_by = 'id', $sort = 'asc');
    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllSections($order_by = 'id', $sort = 'asc');

}