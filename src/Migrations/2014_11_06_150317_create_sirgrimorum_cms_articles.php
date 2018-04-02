<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSirgrimorumCmsArticles extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('nickname',50);
            $table->string('scope',50);
            $table->string('lang',10);
            $table->longtext('content');
            $table->boolean('activated')->default(0);
            $table->integer('user_id')->unsigned()->nullable();
            $table->timestamps();
            $table->unique(array('nickname','lang','scope'));
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('articles');
    }

}