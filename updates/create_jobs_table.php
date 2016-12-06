<?php namespace IIS\Inventory\Updates;

use October\Rain\Database\Updates\Migration;
use Schema;

class CreateJobsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('jobs')) {
            Schema::create('jobs', function ($table) {
                $table->bigIncrements('id');
                $table->string('queue');
                $table->longText('payload');
                $table->tinyInteger('attempts')->unsigned();
                $table->tinyInteger('reserved')->unsigned();
                $table->unsignedInteger('reserved_at')->nullable();
                $table->unsignedInteger('available_at');
                $table->unsignedInteger('created_at');
                $table->index(['queue', 'reserved', 'reserved_at']);
            });
        }
    }

    public function down()
    {
            Schema::dropIfExists('jobs');
    }
}