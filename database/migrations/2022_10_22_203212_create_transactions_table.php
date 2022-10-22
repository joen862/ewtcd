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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->char('hash')->unique();
            $table->integer('blockNumber');
            $table->char('from');
            $table->char('to');
            $table->char('value')->nullable();
            $table->char('condition')->nullable();
            $table->char('creates')->nullable();
            $table->char('gas')->nullable();
            $table->char('gasPrice')->nullable();
            $table->text('input')->nullable();
            $table->char('nonce')->nullable();
            $table->text('publicKey')->nullable();
            $table->text('r')->nullable();
            $table->text('raw')->nullable();
            $table->text('s')->nullable();
            $table->char('standardV')->nullable();
            $table->char('transactionIndex')->nullable();
            $table->char('type')->nullable();
            $table->char('v')->nullable();
            $table->char('chainId')->nullable();
            $table->char('blockHash');
            $table->index('from');
            $table->index('to');
            $table->index('blockNumber');
            $table->index('blockHash');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
