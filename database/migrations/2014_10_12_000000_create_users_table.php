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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('lastname');
            $table->integer('areaId')->nullable();
            $table->longText('currentResoInit')->nullable();
            $table->longText('currentResoEnd')->nullable();
            $table->longText('url_signature')->nullable();
            $table->string('numberResoInit')->nullable();
            $table->string('numberResoEnd')->nullable();
            $table->date('currentDesignationDate')->nullable();
            $table->date('currentTerminationDate')->nullable();
            $table->string('document')->unique();          
            $table->string('password');
            $table->integer('isActive')->default(1);
            $table->string('role')->default('F');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
