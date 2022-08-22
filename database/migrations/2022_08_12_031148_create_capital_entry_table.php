<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCapitalEntryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('capital_entry', function (Blueprint $table) {
            $table->id();
            $table->integer('user');
            $table->decimal('amount', 19, 2)->default(0);
            $table->decimal('fee', 19, 2)->default(0);
            $table->string('method')->default('');
            $table->text('remarks')->default('');
            $table->string('currency')->default('');
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
        Schema::dropIfExists('capital_entry');
    }
}
