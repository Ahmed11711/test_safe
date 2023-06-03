<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('recomondations', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('desc');
            $table->boolean('archive');
            $table->date('start_archive');
            $table->string('img');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('number_of_recived');
            $table->integer('number_show');
            $table->boolean('active');
            $table->unsignedBigInteger('planes_id');

            $table->foreign('planes_id')->references('id')->on('planes');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recomondations');
    }
};
