<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('home_sponsored', function (Blueprint $table) {
            $table->unsignedBigInteger('home_id');
            $table->foreign('home_id')->references('id')->on('homes')->cascadeOnDelete();


            $table->unsignedBigInteger('sponsored_id');
            $table->foreign('sponsored_id')->references('id')->on('sponsoreds')->cascadeOnDelete();

            $table->primary(['home_id', 'sponsored_id']);

            $table->date('initial_date');
            $table->date('end_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('home_sponsored');
    }
};
