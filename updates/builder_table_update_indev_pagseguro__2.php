<?php namespace Indev\Pagseguro\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateIndevPagseguro2 extends Migration
{
    public function up()
    {
        Schema::table('indev_pagseguro_', function($table)
        {
            $table->text('transaction_id');
        });
    }
    
    public function down()
    {
        Schema::table('indev_pagseguro_', function($table)
        {
            $table->dropColumn('transaction_id');
        });
    }
}
