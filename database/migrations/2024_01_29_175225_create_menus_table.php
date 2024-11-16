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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('navheader')->nullable();
            $table->string('url')->nullable();
            $table->string('name_url')->nullable();
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->string('badgeClass')->nullable();
            $table->string('icon')->nullable();
            $table->integer('haveChild')->default(0);
            $table->integer('item_id')->nullable();
            $table->integer('order')->nullable();
            $table->timestamps(4);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menus');
    }
};
