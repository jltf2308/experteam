<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('establishment', 3)->comment('establishment');
            $table->string('emission_point', 3)->comment('emission point');
            $table->integer('secuencial')->comment('secuencial');
            $table->decimal('subtotal', 18, 2)->comment('total guides');
            $table->decimal('taxes', 18, 2)->comment('tax guides');
            $table->decimal('total', 18, 2)->comment('subtotal + taxes guides');
            $table->boolean('status')->default(0)->comment('0 not payed 1 paid out');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
