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
            $table->string('document')->unique();
            $table->string('name');
            $table->string('phone');
            $table->string('address');
            $table->string('city');
            $table->string('state')->default(1);
            $table->unsignedBigInteger('rol_id');
            $table
                ->foreign('rol_id')
                ->references('id')
                ->on('rol');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user');
    }
};
