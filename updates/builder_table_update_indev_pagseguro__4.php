<?php namespace Indev\Pagseguro\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateIndevPagseguro4 extends Migration
{
    public function up()
    {
        Schema::table('indev_pagseguro_', function($table)
        {
            $table->text('reference');
        });
    }
    
    public function down()
    {
        Schema::table('indev_pagseguro_', function($table)
        {
            $table->dropColumn('reference');
        });
    }
}
