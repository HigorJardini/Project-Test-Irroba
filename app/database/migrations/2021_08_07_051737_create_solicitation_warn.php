<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitationWarn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitation_warn', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('classe_solicitation_id');
            $table->foreign('classe_solicitation_id')->references('id')->on('classes_solicitation');

            $table->boolean('warned');
            $table->timestamp('warned_at');
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
        Schema::dropIfExists('solicitation_warn');
    }
}
