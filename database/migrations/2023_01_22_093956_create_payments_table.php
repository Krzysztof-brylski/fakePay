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
        Schema::create('payments', function (Blueprint $table) {
            $table->id('id');
            $table->uuid('token')->unique();
            $table->string('originUrl',100);
            $table->string('statusUpdateUrl',100);
            $table->float('toPay')->unsigned();
            $table->enum('status',['inProgress','success','canceled'])->default('inProgress');
            $table->string('clientEmail',50);
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
        Schema::dropIfExists('payments');
    }
};
