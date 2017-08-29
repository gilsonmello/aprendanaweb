<?php namespace App\Services\Validation;

use Illuminate\Support\ServiceProvider;

use App\Services\Validation\SmartCursosValidation;

class ValidationServiceProvider extends ServiceProvider{

    public function register(){}

    public function boot()
    {
        $this->app->validator->resolver(function($translator, $data, $rules, $messages)
        {
            return new SmartCursosValidation($translator, $data, $rules, $messages);
        });
    }
}