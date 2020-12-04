<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('files')) {
            Schema::create('files', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->uuid('uuid')->unique();
                $table->string('path')->index();
                $table->string('extension')->nullable()->index();
                $table->string('mime')->nullable()->index();
                $table->unsignedBigInteger('size')->index();
                $table->unsignedTinyInteger('type_id')->nullable()->index();
                $table->unsignedBigInteger('thumbnail_id')->nullable()->index();
                $table->unsignedBigInteger('parent_file_id')->nullable()->index();
                $table->timestamps();
                if (config('kakhura.galleriable.use_soft_deletes')) {
                    $table->softDeletes();
                }

                $table->foreign('type_id')->references('id')->on('file_types')->onUpdate('cascade')->onDelete('cascade');
                $table->foreign('thumbnail_id')->references('id')->on('files')->onUpdate('cascade')->onDelete('cascade');
                $table->foreign('parent_file_id')->references('id')->on('files')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('files');
    }
}
