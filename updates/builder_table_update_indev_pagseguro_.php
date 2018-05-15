<?php namespace Indev\Pagseguro\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateIndevPagseguro extends Migration
{
    public function up()
    {
        Schema::table('indev_pagseguro_', function($table)
        {
            $table->integer('user_id');
            $table->increments('id')->unsigned(false)->change();
        });
    }
    
    public function down()
    {
        Schema::table('indev_pagseguro_', function($table)
        {
            $table->dropColumn('user_id');
            $table->increments('id')->unsigned()->change();
        });
    }
}
