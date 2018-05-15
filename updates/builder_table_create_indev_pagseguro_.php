<?php namespace Indev\Pagseguro\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateIndevPagseguro extends Migration
{
    public function up()
    {
        Schema::create('indev_pagseguro_', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->text('items');
            $table->decimal('total', 10, 2);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('indev_pagseguro_');
    }
}
