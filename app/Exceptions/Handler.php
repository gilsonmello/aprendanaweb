<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use \Illuminate\Support\Facades\Response;

class Handler extends ExceptionHandler {

    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        HttpException::class,
        ModelNotFoundException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e) {
        return parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e) {


        if ($e instanceof ModelNotFoundException) {
            $e = new NotFoundHttpException($e->getMessage(), $e);
        }


        //As to preserve the catch all
        if ($e instanceof GeneralException) {
            return redirect()->back()->withInput()->withFlashDanger($e->getMessage());
        }

        if ($e instanceof Backend\Access\User\UserNeedsRolesException) {
            return redirect()->route('admin.access.users.edit', $e->userID())->withInput()->withFlashDanger($e->validationErrors());
        }

        if (!$e instanceof HttpException && $e->getPrevious() instanceof HttpException)
            $e = $e->getPrevious();
        //Catch all
        return $this->treatGenericError($request, $e);
        //return parent::render($request, $e);
    }

    public function treatGenericError($request, $e) {
        $view_return = parent::render($request, $e);

        //if ($view_return->getStatusCode() == 404) {
            //return Response::view("errors.404");
        //} elseif ($view_return->getStatusCode() == 500) {
           // return Response::view("errors.500");
        //} else {
            return $view_return;
       // }
    }

}
