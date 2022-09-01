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
        Schema::create('real_estates', function (Blueprint $table) {
            $table->id();
            $table->string('address');
            $table->float('price');
            $table->integer('number_of_rooms');
            $table->text('description')->nullable();
            $table->boolean('is_rent');
            $table->timestamp('rented_at')->nullable();
            $table->integer('agency_id');
            $table->enum('type', ['Rent', 'Sale']);
            $table->timestamp('sold_date')->nullable();
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
        Schema::dropIfExists('real_estates');
    }
};
