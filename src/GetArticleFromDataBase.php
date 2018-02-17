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

    public static function get($nickname) {
        try {
            $lang = App::getLocale();
            $modelClass = config('sirgrimorum.transarticles.default_articles_model');
            $langColumn = config('sirgrimorum.transarticles.default_lang_column');
            $findArticle = config('sirgrimorum.transarticles.default_findarticle_function_name');
            $article = $modelClass::{$findArticle}($nickname)->where($langColumn, "=", $lang)->first();
            if (count($article)) {
                return $article->content;
            } else {
                $article = $modelClass::{$findArticle}($nickname)->first();
                if (count($article)) {
                    return $article->content . "<small><span class='label label-warning'>" . $article->{$langColumn} . "</span></small>";
                } else {
                    return $nickname;
                }
            }
        } catch (Exception $ex) {
            return $nickname . "<pre class='label label-warning'>" . print_r($ex, true) . "</pre>";
        }
    }

    /**
     * return the JavaScript from article table
     * 
     *
     * @param $scope The scope to load
     * 
     */
    public static function getarticlejs($scope,$basevar='') {
        if($basevar==''){
            $basevar = config('sirgrimorum.transarticles.default_base_var');
        }
        $lang = App::getLocale();
        $listo = false;
        try {
            $modelClass = config('sirgrimorum.transarticles.default_articles_model');
            $langColumn = config('sirgrimorum.transarticles.default_lang_column');
            $findArticles = config('sirgrimorum.transarticles.default_findarticles_function_name');
            $articles = $modelClass::{$findArticles}($scope)->where($langColumn, "=", $lang)->get();
            if (count($articles)) {
                $listo = true;
            } else {
                $articles = $modelClass::{$findArticles}($scope)->get();
                if (count($articles)) {
                    $listo = true;
                    //return $article->content . "<span class='label label-warning'>" . $article->lang . "</span>";
                } else {
                    $jsarray = $langfile;
                }
            }
        } catch (Exception $ex) {
            return $scope . " - Error:" . print_r($ex, true);
        }
        if ($listo) {
            if (count($articles)) {
                $trans = [];
                foreach ($articles as $article) {
                    $trans[$article->nickname] = $article->content;
                }
                $jsarray = json_encode($trans);
            } else {
                $jsarray = $langfile;
            }
        }

        return "<script>window.{$basevar} = window.{$basevar} || {};{$basevar}.{$scope} = {$jsarray};</script>";
    }

}
