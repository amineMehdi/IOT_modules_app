<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('module_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('module_id');
            $table->string('name')->nullable();
            $table->string('type')->nullable();
            $table->string('description')->nullable();
            $table->integer("temperature") ->nullable();
            $table->integer("speed") ->nullable();
            $table->boolean("online")->default(true);
            $table->boolean("functional")->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('module_histories');
    }
};
