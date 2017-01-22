<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesSchoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles_schools', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('organization_id');
            $table->string('summary');
            $table->string('file_name')->nullable();
            $table->string('file_path')->nullable();
            $table->string('file_url')->nullable();
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
        Schema::dropIfExists('profiles_schools');
    }
}
