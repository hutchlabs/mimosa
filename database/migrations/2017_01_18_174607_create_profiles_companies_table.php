<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles_companies', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('organization_id');
            $table->string('summary');
            $table->longText('description')->nullable();
            $table->integer('num_employees')->nullable();
            $table->string('country');
            $table->string('city');
            $table->string('address');
            $table->longText('job_types');
            $table->longText('industries');
            $table->string('website')->nullable();
            $table->string('pic_name');
            $table->string('pic_path')->unique();
            $table->string('pic_url');
            $table->string('file_name');
            $table->string('file_path')->unique();
            $table->string('file_url');
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
        Schema::dropIfExists('profiles_companies');
    }
}
