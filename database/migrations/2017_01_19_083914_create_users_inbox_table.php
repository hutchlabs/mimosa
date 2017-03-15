<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersInboxTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_inbox', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('from_id');
            $table->integer('response_to');
            $table->string('subject');
            $table->longText('message')->nullable();
            $table->boolean('read')->default(0);
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
        Schema::dropIfExists('users_inbox');
    }
}
