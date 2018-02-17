<?php

return [
    /*
      |--------------------------------------------------------------------------
      | Default name of the var for translations in js
      |--------------------------------------------------------------------------
      |
      |
     */
    'default_base_var' => 'translations',
    /*
      |--------------------------------------------------------------------------
      | Default Model for the Articles table
      |--------------------------------------------------------------------------
      |
      |
     */
    'default_articles_model' => 'Sirgrimorum\TransArticles\Models\Article',
    /*
      |--------------------------------------------------------------------------
      | Default column for the lang in Articles table
      |--------------------------------------------------------------------------
      |
      |
     */
    'default_lang_column' => 'lang',
    /*
      |--------------------------------------------------------------------------
      | Default function name for the findArticle in Articles model
      |--------------------------------------------------------------------------
      |
     * public function scopeFindArticle($query, $name) {
        $segments = explode(".", $name);
        $scope = array_shift($segments);
        $nickname = implode(".", $segments);
        return $query->where("activated", "=", "1")->where("scope", "=", $scope)->where("nickname", "=", $nickname);
    }
      |
     */
    'default_findarticle_function_name' => 'findArticle',
    /*
      |--------------------------------------------------------------------------
      | Default function name for the findArticles in Articles model
      |--------------------------------------------------------------------------
      |
     * public function scopeFindArticles($query, $scope) {
        return $query->where("activated", "=", "1")->where("scope", "=", $scope);
    }
      |
     */
    'default_findarticles_function_name' => 'findArticles',
];
