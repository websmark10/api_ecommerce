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
        Schema::create('sale_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->constrained('sales');
            $table->foreignId('product_id')->constrained('products');
            $table->foreignId('discount_type_id')->constrained('discount_types')->nullable()->comment('1 Porcentaje | 2 Moneda');
            $table->double('discount')->nullable();
            $table->double('quantity');
            $table->foreignId('product_variant_dimension_id')->nullable()->constrained('product_variant_dimensions');
            $table->foreignId('product_variant_attribute_id')->nullable()->constrained('product_variant_attributes');
            $table->string('code_coupon')->nullable();
            $table->string('code_discount')->nullable();
            $table->double('price_unit');
            $table->double('price_net');
            $table->double('saved');
            $table->double('subtotal');
            $table->double('total');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sale_details');
    }
};
