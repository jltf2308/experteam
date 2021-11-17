<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_id')->index()->constrained('payments')->onDelete('restrict')->onUpdate('restrict');
            $table->foreignId('invoice_id')->index()->constrained('invoices')->onDelete('restrict')->onUpdate('restrict');
            $table->string('payment_type', 100)->comment('payment type');
            $table->decimal('amount', 18,2)->comment('amount');
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
        Schema::dropIfExists('payment_details');
    }
}
