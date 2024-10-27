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
        Schema::create('cart', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('product_variant_id')->constrained('product_variants');
            $table->foreignId('discount_id')->nullable()->constrained('discounts');
            // $table->foreignId('campaign_id')->constrained('campaigns');
            // $table->foreignId('discount_type_id')->constrained('discount_types')->comment('1 Porcentaje | 2 Moneda');
            // $table->foreignId('discount_apply_id')->constrained('discount_applys');
            // $table->foreignId('discount_method_id')->constrained('discount_methods');
            $table->double('discounted')->nullable();
            $table->double('quantity');
            $table->foreignId('product_variant_dimension_id')->nullable()->constrained('product_variant_dimensions');
            $table->foreignId('product_variant_attribute_id')->nullable()->constrained('product_variant_attributes');
            $table->string('code_coupon')->nullable();
            $table->string('code_discount')->nullable();
            $table->double('price_unit');
            $table->double('price_net')->nullable();
            $table->double('exchange_rate');
            $table->double('price_unit_currencie');
            $table->double('price_net_currencie')->nullable();
            $table->double('exchange_rate_currencie');
           // $table->double('saved');
            $table->double('subtotal');
            $table->double('total');
            $table->foreignId('currencie_id')->constrained('currencies');
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
        Schema::dropIfExists('cart');
    }
};
