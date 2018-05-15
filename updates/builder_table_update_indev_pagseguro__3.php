<?php namespace Indev\Pagseguro\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateIndevPagseguro3 extends Migration
{
    public function up()
    {
        Schema::table('indev_pagseguro_', function($table)
        {
            $table->string('status', 100)->default('aguardando');
        });
    }
    
    public function down()
    {
        Schema::table('indev_pagseguro_', function($table)
        {
            $table->dropColumn('status');
        });
    }
}
