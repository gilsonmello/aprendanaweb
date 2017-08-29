<?php namespace App\Repositories\Backend\GeneralReport;

/**
 * Interface UserContract
 * @package App\Repositories\FaqCategory
 */
interface GeneralReportContract {

    /**
     * @param $id
     * @return mixed
     */
    public function findOrThrowException($id);

    public function getAnnualOrderReports($model,$specific);

    public function getLifetimeOrderReports($model,$specific);

    public function getQuarterlyOrderReports($model,$specific);

    public function getDailyOrderReports($model,$specific);

    public function getTotalSalesReports($model);

}