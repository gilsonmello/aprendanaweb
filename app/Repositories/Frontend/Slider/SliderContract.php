<?php namespace App\Repositories\Frontend\Slider;

/**
 * Interface UserContract
 * @package App\Repositories\Slider
 */
interface SliderContract {

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
    public function getSlidersPaginated($per_page, $order_by = 'id', $sort = 'asc', $f_SliderController_title = '');

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllSliders($order_by = 'id', $sort = 'asc');

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

    /**
     * @param $id
     * @param $filename
     * @return
     */
    public function updateImg($id, $filename);

}