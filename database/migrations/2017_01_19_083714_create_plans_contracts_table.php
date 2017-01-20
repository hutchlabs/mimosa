<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlansContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans_contracts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('organization_id');
            $table->integer('plan_id');
            $table->integer('remaining_posts');
            $table->integer('remaining_notifications');
            $table->date('start_date');
            $table->date('end_date');
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
        Schema::dropIfExists('plans_contracts');
    }
}
