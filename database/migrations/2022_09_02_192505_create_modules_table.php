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
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->index();
            $table->string("name")->nullable();
            $table->string("type")->nullable();
            $table->integer("temperature") ->nullable();
            $table->integer("speed") ->nullable();
            $table->boolean("online")->default(true);
            $table->boolean("functional")->default(true);
            $table->string("description");
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
        Schema::dropIfExists('modules');
    }
};
