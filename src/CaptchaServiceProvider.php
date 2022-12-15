<?php

namespace Karim007\LaravelCaptcha;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Karim007\LaravelCaptcha\Captcha\Captcha;
use Karim007\LaravelCaptcha\Controllers\CaptchaController;

class CaptchaServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__ . '/./config/captcha.php', 'captcha');
        $this->loadViewsFrom(__DIR__ . '/./resources/views', 'captcha');
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'captcha');

        $this->publishes([__DIR__ . '/./config' => config_path()], 'config');
        $this->publishes([__DIR__ . '/./resources/lang' => resource_path('lang')], 'lang');
        $this->publishes([__DIR__ . '/./resources/views' => resource_path('views')], 'views');

        $this->registerRoutes();
        $this->registerBladeDirectives();
        $this->registerValidator();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Captcha::class, function (Application $app) {
            $config = $app['config']['captcha'];

            $storage   = $app->make($config['storage']);
            $generator = $app->make($config['generator']);
            $code      = $app->make($config['code']);

            return new Captcha($code, $storage, $generator, $config);
        });
    }

    /**
     * Register the blade directives
     *
     * @return void
     */
    protected function registerBladeDirectives()
    {
        if (! class_exists('\Blade')) {
            return;
        }

        Blade::directive(config('captcha.blade'), function () {
            return "<?php echo Karim007\\LaravelCaptcha\\Facades\\Captcha::getView() ?>";
        });
    }

    /**
     * Register captcha routes.
     */
    protected function registerRoutes()
    {
        $this->app['router']->group([
            'middleware' => config('captcha.middleware', 'web'),
            'namespace'  => 'Karim007\LaravelCaptcha\Controllers',
            'as'         => 'captcha.'
        ], function ($router) {
            $router->get(config('captcha.routes.image'), [CaptchaController::class,'image'])->name('image');
            $router->get(config('captcha.routes.image_tag'), [CaptchaController::class,'imageTag'])->name('image.tag');
        });
    }

    /**
     * Register captcha validator.
     */
    protected function registerValidator()
    {
        Validator::extend(config('captcha.validator'), function ($attribute, $value, $parameters, $validator) {
            return $this->app[Captcha::class]->validate($value);
        }, trans('captcha::captcha.incorrect_code'));
    }
}
