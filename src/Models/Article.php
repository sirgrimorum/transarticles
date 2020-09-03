<?php

namespace Sirgrimorum\TransArticles\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model {

    public $rules = [//The validation rules
        'nickname' => 'bail|required|max:255',
        'scope' => 'bail|required|max:255',
        'lang' => 'bail|required|max:255',
        'content' => 'required',
    ];
    public $error_messages = []; //The validation error messages

    public function _construct() {
        $this->error_messages = [
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
    
    public function user() {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the flied value using the configuration array
     * 
     * @param string $key The field to return
     * @param boolean $justValue Optional If return just the formated value (true) or an array with 3 elements, label, value and data (detailed data for the field)
     * @return mixed
     */
    public function get($key, $justValue = true)
    {
        if (!class_exists('\Sirgrimorum\CrudGenerator\CrudGenerator')) {
            $celda = \Sirgrimorum\CrudGenerator\CrudGenerator::field_array($this, $key);
            if ($justValue) {
                return $celda['value'];
            } else {
                return $celda;
            }
        }
        if ($justValue) {
            return $this->{$key};
        } else {
            return [
                'value' => $this->{$key},
                "data" => $this->{$key},
                "label" => $key
            ];
        }
    }

}
