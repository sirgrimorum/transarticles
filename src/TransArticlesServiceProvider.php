<?php

namespace Sirgrimorum\TransArticles;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Foundation\AliasLoader;
use Sirgrimorum\TransArticles\GetArticleFromDataBase;

class TransArticlesServiceProvider extends ServiceProvider {

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot() {
        $this->publishes([
            __DIR__ . '/Config/transarticles.php' => config_path('sirgrimorum/transarticles.php'),
                ], 'config');
        $this->loadMigrationsFrom(__DIR__ . '/Migrations');

        Blade::directive('transarticles_tojs', function($scope, $basevar = '') {
            $translations = new \SirGrimorum\TransArticles\GetArticleFromDataBase($this->app);
            return $translations->getarticle(str_replace(['(', ')', ' ', '"', "'"], '', $scope), $basevar);
        });
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register() {
        //AliasLoader::getInstance()->alias('TransArticles', GetArticleFromDataBase::class);
        $loader = AliasLoader::getInstance();
            $loader->alias(
                    'TransArticles', GetArticleFromDataBase::class
            );
        $this->app->singleton(GetArticleFromDataBase::class, function ($app) {
            return new GetArticleFromDataBase($app);
        });
        //$this->app->alias(GetArticleFromDataBase::class, 'TransArticles');
        $this->mergeConfigFrom(
                __DIR__ . '/Config/transarticles.php', 'sirgrimorum.transarticles'
        );
    }

}
