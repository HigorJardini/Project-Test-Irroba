<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassesSolicitation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classes_solicitation', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('classes_student_id');
            $table->foreign('classes_student_id')->references('id')->on('classes_student');

            $table->unsignedBigInteger('classes_teacher_id');
            $table->foreign('classes_teacher_id')->references('id')->on('classes_teacher');

            $table->boolean('accept');
            $table->text('reason');
            $table->boolean('canceled');
            $table->timestamp('accepted_at');
            $table->timestamp('canceled_at');

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
        Schema::dropIfExists('classes_solicitation');
    }
}
