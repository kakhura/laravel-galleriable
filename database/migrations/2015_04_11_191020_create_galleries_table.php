<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGalleriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('galleries')) {
            Schema::create('galleries', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->morphs('galleriable');
                $table->unsignedBigInteger('image_id')->index();
                $table->unsignedTinyInteger('sort_index')->default(0)->index();
                $table->timestamps();
                if (config('kakhura.galleriable.use_soft_deletes')) {
                    $table->softDeletes();
                }

                $table->foreign('image_id')->references('id')->on('files')->onDelete('cascade')->onUpdate('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('galleries');
    }
}
