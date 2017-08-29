<?php

namespace App\Repositories\Frontend\View;

use App\ViewLog;
use App\Exceptions\GeneralException;


/**
 * Class EloquentViewRepository
 * @package App\Repositories\View
 */
class EloquentViewLogRepository implements ViewLogContract {
//	public function __construct() {
//	}

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function findOrThrowException($id) {
        $view = ViewLog::withTrashed()->find($id);

        if (!is_null($view))
            return $view;

        throw new GeneralException('That views does not exist.');
    }

    public function findByEnrollmentAndContent($enrollment_id, $content_id) {
        return ViewLog::where('enrollment_id', $enrollment_id)->where('content_id', $content_id)->get();
    }

    public function createViewLog($enrollment, $content) {
        $view_log = $this->createViewLogStub();
        $view_log->content()->associate($content);
        $view_log->enrollment()->associate($enrollment);
        
        if ($view_log->save()) {
            return $view_log;
        }
    }

    public function createViewLogStub() {
        $view_log = new View;
        $view_log->datetime_view = Carbon::now();
        return $view_log;
    }

}
