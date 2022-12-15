<?php

namespace Karim007\LaravelCaptcha\Facades;

use Illuminate\Support\Facades\Facade;

class Captcha extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \Karim007\LaravelCaptcha\Captcha\Captcha::class;
    }
}
