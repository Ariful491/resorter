<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('code',200)->unique();
            $table->enum('type',['Standard','Combo','Service'])->default('Standard');
            $table->foreignId('category_id')->references('id')->on('categories');
            $table->string('name');
            $table->decimal('price',25,4);
            $table->decimal('tax',25,4)->nullable();
            $table->decimal('cost',25,4)->nullable();
            $table->integer('qty')->default('1');
            $table->string('barcode_symbology');
            $table->text('image');
            $table->integer('qty_alert');
            $table->longText('details')->nullable();
            $table->enum('status', ['In Active','Active']);
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
        Schema::dropIfExists('items');
    }
}
