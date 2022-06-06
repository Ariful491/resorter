<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->references('id')->on('customers');
            $table->date('delivery_date');
            $table->foreignId('mapping_master')->references('id')->on('employees');
            $table->foreignId('cutting_master')->references('id')->on('employees');
            $table->string('reference_notes');
            $table->float('total_amount',8,2);
            $table->float('total_tax',8,2)->default(0);
            $table->float('discount',8,2)->default(0);
            $table->float('payable_amount',8,2);
            $table->float('due',8,2);
            $table->string('month');
            $table->string('year');
            $table->enum('status', ['In Active','Active']);
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
        Schema::dropIfExists('order_details');
    }
}
