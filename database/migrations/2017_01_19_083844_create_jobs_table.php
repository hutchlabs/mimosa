<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('organization_id');
            $table->integer('contract_id');
            $table->mediumText('school_ids');
            $table->string('title');
            $table->string('teaser');
            $table->longText('description_text')->nullable();
            $table->string('file_name')->nullable();
            $table->string('file_path')->nullable();
            $table->string('file_url')->nullable();            
            $table->longText('job_types')->nullable();
            $table->longText('positions')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->boolean('remote')->default(0);
            $table->string('send_via_email')->nullable();
            $table->string('send_via_url')->nullable();
            $table->string('video_title')->nullable();
            $table->string('video_url')->nullable();
            $table->boolean('preselect')->default(0);
            $table->integer('questionnaire_id')->nullable();
            $table->longText('questionnaire_values')->nullable(); 
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('status')->default(0);
            $table->boolean('featured')->default(0);
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
        Schema::dropIfExists('jobs');
    }
}
