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
        Schema::create('market', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->char('price',255)->nullable();
            $table->char('volume_24h',255)->nullable();
            $table->char('volume_change_24h',255)->nullable();
            $table->char('percent_change_1h',255)->nullable();
            $table->char('percent_change_24h',255)->nullable();
            $table->char('percent_change_7d',255)->nullable();
            $table->char('percent_change_30d',255)->nullable();
            $table->char('percent_change_60d',255)->nullable();
            $table->char('percent_change_90d',255)->nullable();
            $table->char('market_cap',255)->nullable();
            $table->char('market_cap_dominance',255)->nullable();
            $table->char('fully_diluted_market_cap',255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('market');
    }
};
