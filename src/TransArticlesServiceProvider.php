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

        Blade::directive('transarticles', function($nickname) {
            $translations = new \Sirgrimorum\TransArticles\GetArticleFromDataBase($this->app);
            return $translations->get(str_replace(['(', ')', ' ', '"', "'"], '', $nickname));
        });
        Blade::directive('transarticles_tojs', function($expression) {
            $auxExpression = explode(',', str_replace(['(', ')', ' ', '"', "'"], '', $expression));
            if (count($auxExpression)>1) {
                $scope = $auxExpression[0];
                $basevar = $auxExpression[1];
            } else {
                $scope = $auxExpression[0];
                $basevar = "";
            }
            $translations = new \Sirgrimorum\TransArticles\GetArticleFromDataBase($this->app);
            return $translations->getjs($scope, $basevar);
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
        $this->app->singleton(GetArticleFromDataBase::class, function($app) {
            return new GetArticleFromDataBase($app);
        });
        //$this->app->alias(GetArticleFromDataBase::class, 'TransArticles');
        $this->mergeConfigFrom(
                __DIR__ . '/Config/transarticles.php', 'sirgrimorum.transarticles'
        );
    }

}
