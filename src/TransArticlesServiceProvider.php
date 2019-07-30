<?php

namespace Sirgrimorum\TransArticles;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Foundation\AliasLoader;
use Sirgrimorum\TransArticles\GetArticleFromDataBase;
use Illuminate\Support\Facades\Artisan;

class TransArticlesServiceProvider extends ServiceProvider {

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
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
            if (count($auxExpression) > 1)
            {
                $scope = $auxExpression[0];
                $basevar = $auxExpression[1];
            }
            else
            {
                $scope = $auxExpression[0];
                $basevar = "";
            }
            $translations = new \Sirgrimorum\TransArticles\GetArticleFromDataBase($this->app);
            return $translations->getjs($scope, $basevar);
        });

        Artisan::command('transarticles:createseed', function () {
            $bar = $this->output->createProgressBar(2);
            $confirm = $this->choice("Do you wisth to clean the DatabaseSeeder.php list?", ['yes', 'no'], 0);
            $bar->advance();
            $nombre = date("YmdHis");
            if ($confirm == 'yes') {
                $this->line("Creating seed archive of articles table and celaning DatabaseSeeder");
                Artisan::call("iseed articles --classnamesuffix={$nombre} --chunksize=100 --clean");
            } else {
                $this->line("Creating seed archive of articles table and adding to DatabaseSeeder list");
                Artisan::call("iseed articles --classnamesuffix={$nombre} --chunksize=100");
            }
            $this->info("Seed file created with the name Articles{$nombre}Seeder.php");
            $bar->advance();
            $bar->finish();
        })->describe('Create a seeder file with the current table Articles');
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
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
