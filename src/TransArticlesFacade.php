<?php namespace Sirgrimorum\TransArticles;

use Illuminate\Support\Facades\Facade;

class TransArticlesFacade extends Facade {

    /**
     * Name of the binding in the IoC container
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'TransArticles';
    }

} 