<?php

namespace Coop182\LaravelCronValidator;

use Illuminate\Support\ServiceProvider;

class CronValidatorServiceProvider extends ServiceProvider
{
    public function register() {}

    public function boot()
    {
        $this->app->validator->resolver(function($translator, $data, $rules, $messages = array(), $customAttributes = array()) {
            return new CronValidator($translator, $data, $rules, $messages, $customAttributes);
        });
    }

}
