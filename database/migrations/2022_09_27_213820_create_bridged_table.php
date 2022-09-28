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
        Schema::create('bridged', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->char('minted',255)->nullable();
            $table->char('tx_last_day',255)->nullable();
            $table->char('tx_last_week',255)->nullable();
            $table->char('tx_last_month',255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bridged');
    }
};
