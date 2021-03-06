<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesStudentWorkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('profiles_student_work', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('company');
            $table->string('title');
            $table->longText('description');
            $table->longText('industries');
            $table->string('country');
            $table->string('city');
            $table->string('neighborhood');
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('current')->default(0);
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
        Schema::dropIfExists('profiles_student_work');
    }
}
