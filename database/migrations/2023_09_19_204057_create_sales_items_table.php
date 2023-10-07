<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {

        Schema::create('sales_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products');
            $table->unsignedBigInteger('sale_id');
            $table->foreign('sale_id')->references('id')->on('sales');
            $table->bigInteger('quantity');
            $table->decimal('unit_price',8,2);
            $table->decimal('total_price',8,2);
            $table->timestamps();

        });

    }


    public function down(): void
    {
        Schema::dropIfExists('sales_items');
    }
};
