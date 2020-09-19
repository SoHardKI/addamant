<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTireTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tires', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->integer('width')->nullable(true);
            $table->integer('profile')->nullable(true);
            $table->string('diameter')->nullable(true);
            $table->integer('load_index')->nullable(true);
            $table->string('speed_index')->nullable(true);
            $table->integer('count')->nullable(true);
            $table->integer('price')->nullable(true);
            $table->unsignedInteger('manual_distribution')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tires');
    }
}
