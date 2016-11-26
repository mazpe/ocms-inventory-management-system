<?php namespace Mesadev\Inventory\Updates;

use October\Rain\Database\Updates\Migration;
use Schema;

class CreateItemsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('mesadev_inventory_items')) {
            Schema::create('mesadev_inventory_items', function ($table) {
                $table->engine = 'InnoDB';
                $table->increments('id');
                $table->string('facebook_post_id')->nullable()->index();
                $table->string('twitter_post_id')->nullable()->index();
                $table->string('category')->index();
                $table->string('serial')->index();
                $table->string('year')->index();
                $table->string('make')->index();
                $table->string('model')->index();
                $table->string('registration')->index();
                $table->text('description')->nullable();
                $table->text('log')->nullable();
                $table->text('engine')->nullable();
                $table->text('avionics')->nullable();
                $table->text('features')->nullable();
                $table->text('interior')->nullable();
                $table->text('exterior')->nullable();
                $table->text('maintenance')->nullable();
                $table->text('inspections')->nullable();
                $table->text('comments')->nullable();

                $table->decimal('price',10, 2)->nullable();
                $table->timestamp('published_at')->nullable();
                $table->boolean('is_published')->default(false);
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    public function down()
    {
            Schema::dropIfExists('mesadev_inventory_items');
    }
}