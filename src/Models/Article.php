<?php

namespace Sirgrimorum\TransArticles\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model {

    public $rules = [ //The validation rules
        'nickname' => 'bail|required|max:255',
        'scope' => 'bail|required|max:255',
        'lang' => 'bail|required|max:255',
        'content' => 'required',
    ];
    public $error_messages = []; //The validation error messages

    public function _construct() {
        $error_messages = [
        ];
    }

    public function scopeFindArticle($query, $name) {
        $segments = explode(".", $name);
        $scope = array_shift($segments);
        $nickname = implode(".", $segments);
        return $query->where("activated", "=", "1")->where("scope", "=", $scope)->where("nickname", "=", $nickname);
    }

    public function scopeFindArticles($query, $scope) {
        return $query->where("activated", "=", "1")->where("scope", "=", $scope);
    }

    public function getNameAttribute() {
        return $this->scope . "." . $this->nickname . " (" . $this->lang . ")";
    }
    
    public function user(){
        return $this->belongsTo('App\User');
    }

}
