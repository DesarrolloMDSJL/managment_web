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
        Schema::create('user_controls', function (Blueprint $table) {
            $table->id();
            $table->integer('userId');
            $table->string('type')->default('I');
            $table->longText('url')->nullable();
            $table->date('date')->nullable();
            $table->integer('userRegisterId')->nullable();
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
        Schema::dropIfExists('user_controls');
    }
};
