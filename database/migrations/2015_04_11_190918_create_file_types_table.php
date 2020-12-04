<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('file_types')) {
            Schema::create('file_types', function (Blueprint $table) {
                $table->tinyIncrements('id');
                $table->string('key')->unique();
                $table->string('display_name');
                $table->timestamps();
                if (config('kakhura.galleriable.use_soft_deletes')) {
                    $table->softDeletes();
                }
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
        Schema::dropIfExists('file_types');
    }
}
