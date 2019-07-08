<?php

namespace Sirgrimorum\TransArticles;

use Exception;
use Sirgrimorum\TransArticles\Models\Article;
use App;

class GetArticleFromDataBase {

    /**
     * Actual localization
     * 
     * @var string 
     */
    protected $lang;

    /**
     * @var string
     */
    private $app;

    /**
     * 
     * @param string $lang If '' get the current localization
     */
    function __construct($app, $lang = '') {
        $this->app = $app;
        if ($lang == '') {
            $this->lang = $this->app->getLocale();
        } else {
            $this->lang = $lang;
        }
    }
    
    /**
     * Return the translation for the article
     * @param String $nickname The article to load using dot notation
     * @return String The content of the article localized, if not found, return the first article in a diferent language, if neither, returns de $nickname
     */
    public static function get($nickname) {
        try {
            $lang = App::getLocale();
            $modelClass = config('sirgrimorum.transarticles.default_articles_model');
            $langColumn = config('sirgrimorum.transarticles.default_lang_column');
            $findArticle = config('sirgrimorum.transarticles.default_findarticle_function_name');
            $article = $modelClass::{$findArticle}($nickname)->where($langColumn, "=", $lang)->first();
            if ($article) {
                return $article->content;
            } else {
                $article = $modelClass::{$findArticle}($nickname)->first();
                if ($article) {
                    return $article->content . "<small><span class='label label-warning'>" . $article->{$langColumn} . "</span></small>";
                } else {
                    return $nickname;
                }
            }
        } catch (Exception $ex) {
            return $nickname . "<pre class='label label-warning'>" . print_r([$ex->getMessage(), $ex->getTraceAsString()], true) . "</pre>";
        }
    }

    /**
     * return the JavaScript from article table
     * 
     *
     * @param String $scope The scope to load
     * 
     */
    public static function getjs($scope, $basevar = '') {
        if ($basevar == '') {
            $basevar = config('sirgrimorum.transarticles.default_base_var');
        }
        $lang = App::getLocale();
        $listo = false;
        try {
            $modelClass = config('sirgrimorum.transarticles.default_articles_model');
            $langColumn = config('sirgrimorum.transarticles.default_lang_column');
            $findArticles = config('sirgrimorum.transarticles.default_findarticles_function_name');
            $findArticle = config('sirgrimorum.transarticles.default_findarticle_function_name');
            $articles = $modelClass::{$findArticles}($scope)->where($langColumn, "=", $lang)->get();
            if ($articles) {
                $listo = true;
            } else {
                $articles = $modelClass::{$findArticles}($scope)->get();
                if ($articles) {
                    $listo = true;
                } else {
                    $articles = $modelClass::{$findArticle}($scope)->where($langColumn, "=", $lang)->first();
                    $listo = false;
                    if ($articles) {
                        $jsarray = [];
                        data_fill($jsarray, $scope, $articles->content);
                    } else {
                        $articles = $modelClass::{$findArticle}($scope)->first();
                        if ($articles) {
                            $jsarray = [];
                            data_fill($jsarray, $scope, $articles->content);
                            //$jsarray = $articles->content;
                        } else {
                            $jsarray = [];
                            data_fill($jsarray, $scope, $scope);
                        }
                    }
                }
            }
        } catch (Exception $ex) {
            return $scope . " - Error:" . print_r($ex->getMessage(), true);
        }
        if ($listo) {
            if ($articles) {
                $trans = [];
                foreach ($articles as $article) {
                    $trans[$article->nickname] = $article->content;
                }
                $jsarray = json_encode($trans);
                return "<script>window.{$basevar} = window.{$basevar} || {};{$basevar}.{$scope} = {$jsarray};</script>";
            } else {
                $jsarray = [];
                data_fill($jsarray, $scope, $scope);
            }
        } 
        $jsarray = json_encode($jsarray);
        return "<script>window.{$basevar} = window.{$basevar} || {};{$basevar} = {$jsarray};</script>";
    }

}
