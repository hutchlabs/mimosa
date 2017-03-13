<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesStudentEducationPrimaryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('profiles_student_education_primary', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('school');
            $table->string('country');
            $table->integer('graduation_month');
            $table->integer('graduation_year');
            $table->boolean('visible');
            $table->integer('modified_by');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profiles_student_education_primary');
    }
}
