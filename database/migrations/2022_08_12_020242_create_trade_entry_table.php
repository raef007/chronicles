<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTradeEntryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trade_entry', function (Blueprint $table) {
            $table->id();
            
            $table->datetime('entered_at')->nullable();
            $table->datetime('closed_at')->nullable();
            $table->string('asset_pair')->default('');
            $table->decimal('opening_price', 19, 2)->default(0);
            $table->decimal('closing_price', 19, 2)->default(0);
            $table->decimal('quantity', 19, 2)->default(0);
            $table->decimal('stop_loss', 19, 2)->default(0);
            $table->string('status')->default('');
            $table->string('position')->default('');
            $table->unsignedSmallInteger('is_stopped_out')->default(0);
            $table->integer('created_by');
            $table->softDeletes();
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
        Schema::dropIfExists('trade_entry');
    }
}
