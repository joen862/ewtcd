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
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->char('slug',255)->index()->nullable();
            $table->char('label',255)->nullable();
            $table->char('category',255)->index()->nullable();
            $table->char('address',255)->index();
            $table->integer('balance')->nullable();
            $table->text('notes')->nullable();
            $table->dateTime('balance_last_update');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wallets');
    }
};
