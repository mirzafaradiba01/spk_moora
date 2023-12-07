<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Alternatifskor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alternatifskor', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('alternatif_id');
            $table->foreign('alternatif_id')->references('id')->on('alternatif')->onDelete('cascade');
            
            $table->unsignedBigInteger('kriteriabobot_id');
            $table->foreign('kriteriabobot_id')->references('id')->on('kriteriabobot')->onDelete('cascade');

            $table->float('score');
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
        Schema::dropIfExists('alternatifskor');
    }
}
