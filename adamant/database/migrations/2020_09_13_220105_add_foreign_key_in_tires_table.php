<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyInTiresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tires', function (Blueprint $table) {
            $table->bigInteger('manufacturer_id')->unsigned()->nullable(true);
            $table->bigInteger('tire_model_id')->unsigned()->nullable(true);

            $table->foreign('manufacturer_id')->references('id')->on('manufacturers');
            $table->foreign('tire_model_id')->references('id')->on('tire_models');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tires', function (Blueprint $table) {
            $table->dropForeign('tires_manufacturer_id_foreign');
            $table->dropForeign('tires_tire_model_id_foreign');
            $table->dropColumn([
                'manufacturer_id'
            ]);
            $table->dropColumn([
                'tire_model_id'
            ]);
        });
    }
}
