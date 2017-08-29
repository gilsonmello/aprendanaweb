<?php namespace App\Repositories\Backend\GeneralReport;

use App\Course;
use App\OrderCourse;
use App\OrderLesson;
use App\OrderModule;
use App\Exceptions\GeneralException;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Class EloquentFaqCategoryRepository
 * @package App\Repositories\FaqCategory
 */
class EloquentGeneralReportRepository implements GeneralReportContract {


//	public function __construct() {
//	}

	/**
	 * @param $id
	 * @return mixed
	 * @throws GeneralException
	 */
	public function findOrThrowException($id) {
		//$faqCategory = FaqCategory::withTrashed()->find($id);

		//if (! is_null($faqCategory)) return $faqCategory;

		throw new GeneralException('That FAQ Category does not exist.');
	}


public function getAnnualOrderReports($model,$specific){
    $actual_time = Carbon::now();

    $table = $model->getModel()->getTable();
    $orders = $model->join('orders', 'orders.id', '=', $table . '.order_id')
        ->where('orders.date_registration', '>', $actual_time->subYear())->where('orders.status_id', 4);

    
    if($specific != null){

        $relevant_name = explode('_',$table)[1];
        $relevant_name = substr($relevant_name,0,-1);
        $orders = $orders->where($relevant_name .'_id',$specific);

    }



    $order_by_group = [];

    foreach($orders->get()->sortBy(function($item){ return $item->order->date_registration;}) as $order) {

        if (isset($order->order->date_registration)) {
            $carbon = new Carbon($order->order->date_registration);
            $month_and_year = $carbon->month . '/' . $carbon->year;
            if (!isset($order_by_group[$month_and_year])) {
                $order_by_group[$month_and_year] = 1;
            } else {
                $order_by_group[$month_and_year]++;
            }
        }
    }


    return $order_by_group;



}

    public function getQuarterlyOrderReports($model,$specific){
        $actual_time = Carbon::now();


        $orders = $model->join('orders', 'orders.id', '=', $model->getModel()->getTable() . '.order_id')
            ->where('orders.date_registration', '>', $actual_time->subMonths(6))->where('orders.status_id', 4);


        if($specific != null){

            $relevant_name = explode('_',$model->getModel()->getTable())[1];
            $relevant_name = substr($relevant_name,0,-1);
            $orders = $orders->where($relevant_name .'_id',$specific);

        }





        $order_by_group = [];
        foreach($orders->get() as $order){

            $carbon = new Carbon($order->order->date_registration);
            $week_and_month = $carbon->weekOfMonth . '/' . $carbon->month;
            if(!isset($order_by_group[$week_and_month])) {
                $order_by_group[$week_and_month] = 1;
            }else{
                $order_by_group[$week_and_month]++;
            }
        }

        return $order_by_group;

    }


    public function getDailyOrderReports($model,$specific){
        $actual_time = Carbon::now();


        $orders = $model->join('orders', 'orders.id', '=', $model->getModel()->getTable() . '.order_id')
            ->where('orders.date_registration', '>', $actual_time->subMonth())->where('orders.status_id', 4);


        if($specific != null){
            $relevant_name = explode('_',$model->getModel()->getTable())[1];
            $relevant_name = substr($relevant_name,0,-1);
            $orders = $orders->where($relevant_name .'_id',$specific);

        }





        $order_by_group = [];
        foreach($orders->get() as $order){

            $carbon = new Carbon($order->order->date_registration);
            $day_and_month = $carbon->day . '/' . $carbon->month;
            if(!isset($order_by_group[$day_and_month])) {
                $order_by_group[$day_and_month] = 1;
            }else{
                $order_by_group[$day_and_month]++;
            }
        }

        return $order_by_group;



    }


    public function getLifetimeOrderReports($model,$specific){
        $actual_time = Carbon::now();



        $orders = $model;


        if($specific != null){
            $relevant_name = explode('_',$model->getModel()->getTable())[1];
            $relevant_name = substr($relevant_name,0,-1);
            $orders = $orders->where($relevant_name .'_id',$specific);

        }





        $order_by_group = [];
        foreach($orders->get() as $order){

            $carbon = new Carbon($order->order->date_registration);
            $day_and_month = $carbon->year;
            if(!isset($order_by_group[$day_and_month])) {
                $order_by_group[$day_and_month] = 1;
            }else{
                $order_by_group[$day_and_month]++;
            }
        }



        return $order_by_group;


    }


    public function getTotalSalesReports($model){

        $relevant_name_plural = explode('_',$model->getModel()->getTable())[1];
        $relevant_name = substr($relevant_name_plural,0,-1);
        $actual_time = Carbon::now();

        $orders = $model->join('orders', 'orders.id', '=', $model->getModel()->getTable() . '.order_id')
            ->groupBy($model->getModel()->getTable() . '.' . $relevant_name . '_id') ->where('orders.date_registration', '>', $actual_time->subMonths(1))->where('orders.status_id', 4)->select($relevant_name . '_id as id' , DB::raw('count(*) as orders'))->orderBy('orders','desc');

        $key_value = [];
        $key_value['Outros'] = 0;
        $i = 0;
        foreach($orders->get() as $order){

            if($i < 10){
            $id = $order['id'];

            $name = Course::find($id);
            if($name == null){
                continue;
            }
            $key_value[$name->title] = $order->orders;
            $i++;
            }else{
                $key_value['Outros'] = $order->orders + $key_value['Outros'];
            }
           // $key_value[$orders->orders] = $name;

        }


        //dd($orders->lists($relevant_name . '_id', 'count(*)'));
        return $key_value;

    }



}