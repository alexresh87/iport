<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfferTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->bigInteger('id')->unsigned()->unique();
            $table->boolean('available')->default(0);
            $table->string('url')->nullable();
            $table->float('price')->default(0.0);
            $table->string('currencyId')->nullable();
            $table->unsignedBigInteger('categoryId');
            $table->string('market_category')->nullable();
            $table->boolean('store')->default(0);
            $table->boolean('pickup')->default(0);
            $table->boolean('delivery')->default(0);
            $table->text('delivery-options')->nullable();
            $table->string('model')->nullable();
            $table->string('typePrefix')->nullable();
            $table->string('vendor')->nullable();
            $table->text('description')->nullable();
            $table->string('vendorCode')->nullable();
            $table->string('sales_notes')->nullable();
            $table->string('barcode')->nullable();
            $table->primary('id');
            $table->timestamps();

            $table->foreign('categoryId')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offers');
    }
}
