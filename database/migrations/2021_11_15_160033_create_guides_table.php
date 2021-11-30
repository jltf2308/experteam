<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guides', function (Blueprint $table) {
            $table->id();
            $table->string('guide_number', 10)->comment('guide number');
            $table->date('shipping_date')->comment('shipping date, format yyyy-mm-dd');
            $table->string('country_origin', 100)->comment('country of origin');
            $table->string('sender_name', 100)->comment('sender name');
            $table->string('sender_address', 100)->comment('sender address');
            $table->string('sender_phone', 100)->comment('sender phone');
            $table->string('sender_email', 100)->comment('sender email');
            $table->string('destination_country', 100)->comment('destination country');
            $table->string('recipient_name', 100)->comment('recipient name');
            $table->string('recipient_address', 100)->comment('recipient address');
            $table->string('recipient_phone', 100)->comment('recipient phone');
            $table->string('recipient_email', 100)->comment('recipient email');
            $table->decimal('total', 18, 2)->comment('total');
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
        Schema::dropIfExists('guides');
    }
}
