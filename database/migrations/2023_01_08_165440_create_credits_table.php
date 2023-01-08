<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credits', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('subject_user_id');
            $table
                ->foreign('subject_user_id')
                ->references('id')
                ->on('subject_user');

            $table->unsignedBigInteger('semesters_id');
            $table
                ->foreign('semesters_id')
                ->references('id')
                ->on('semesters');

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
        Schema::dropIfExists('credits');
    }
};
