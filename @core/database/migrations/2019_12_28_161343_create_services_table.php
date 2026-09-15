<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('icon')->nullable();
            $table->string('lang')->nullable();
            $table->string('categories_id');
            $table->string('image')->nullable();
            $table->text('excerpt')->nullable();
            $table->text('description');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('services');
    }
}
