<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateThemesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('themes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('organization_id');
            $table->longText('home_header')->nullable();
            $table->longText('home_first_title')->nullable();
            $table->longText('home_first')->nullable();
            $table->longText('home_second_title')->nullable();
            $table->longText('home_second')->nullable();
            $table->longText('home_third_title')->nullable();
            $table->longText('home_third')->nullable();
            $table->string('home_hero')->nullable();
            $table->longText('partners_header')->nullable();
            $table->longText('partners_first_title')->nullable();
            $table->longText('partners_first')->nullable();
            $table->longText('partners_second_title')->nullable();
            $table->longText('partners_second')->nullable();
            $table->longText('partners_third_title')->nullable();
            $table->longText('partners_third')->nullable();
            $table->string('partners_hero')->nullable();
            $table->longText('contact_header')->nullable();
            $table->longText('contact_first_title')->nullable();
            $table->longText('contact_first')->nullable();
            $table->longText('contact_second_title')->nullable();
            $table->longText('contact_second')->nullable();
            $table->longText('contact_third_title')->nullable();
            $table->longText('contact_third')->nullable();
            $table->string('contact_hero')->nullable();
            $table->integer('modified_by')->default(1); // default: super admin
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
        Schema::dropIfExists('themes');
    }
}
