<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSystemPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('organization_id');
            $table->boolean('preselect')->default(0);
            $table->boolean('screening')->default(0);
            $table->boolean('tracking')->default(0);
            $table->boolean('badges')->default(0);
            $table->boolean('events')->default(0);
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
        Schema::dropIfExists('system_permissions');
    }
}
