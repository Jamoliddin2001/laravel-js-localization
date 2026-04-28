<?php
namespace JsLocalization;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;
use JsLocalization\Caching\ConfigCachingService;
use JsLocalization\Caching\MessageCachingService;
use JsLocalization\Console\ExportCommand;
use JsLocalization\Console\RefreshCommand;
use JsLocalization\Utils\Helper;

class JsLocalizationServiceProvider extends ServiceProvider {

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/config.php' => config_path('js-localization.php')
        ]);

        $this->publishes([
            __DIR__.'/../public/js/localization.min.js' => public_path('vendor/js-localization/js-localization.min.js'),
        ], 'public');

        $this->mergeConfigFrom(
            __DIR__.'/../config/config.php', 'js-localization'
        );

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'js-localization');

        $this->loadRoutesFrom(__DIR__.'/Http/routes.php');

        $this->registerRefreshCommand();
        $this->registerExportCommand();
    }

    public function register()
    {
        $this->app->singleton('JsLocalizationHelper', function () {
            return new Helper;
        });

        $this->app->singleton('JsLocalizationMessageCachingService', function () {
            return new MessageCachingService;
        });

        $this->app->singleton('JsLocalizationConfigCachingService', function () {
            return new ConfigCachingService;
        });
    }

    public function provides()
    {
        return ['js-localization'];
    }

    private function registerRefreshCommand()
    {
        $this->app->singleton('js-localization.refresh', function () {
            return new RefreshCommand;
        });

        $this->commands('js-localization.refresh');
    }

    private function registerExportCommand()
    {
        $this->app->singleton('js-localization.export', function () {
            return new ExportCommand;
        });

        $this->commands('js-localization.export');
    }

}
