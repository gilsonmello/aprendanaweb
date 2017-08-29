<?php namespace App\Repositories\Frontend\Subsection;

/**
 * Interface UserContract
 * @package App\Repositories\Section
 */
interface SubsectionContract {

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

    public function getAllSubsectionsBySection($section_id, $order_by = 'id', $sort = 'asc');

}