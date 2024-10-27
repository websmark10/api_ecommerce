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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreignId('product_variant_attribute_id')->nullable() ->constrained('product_variant_attributes');
            $table->foreignId('product_variant_dimension_id')->nullable() ->constrained('product_variant_dimensions');

            // $table->foreignId('product_variant_attribute_id')->default(1)->constrained('product_variant_attributes');
            // $table->foreignId('product_variant_dimension_id')->references('id')->on('product_variant_dimensions')->onDelete('cascade');

            // $table->foreignId('product_variant_attribute_id')->references('id')->on('product_variant_attributes')->onDelete('cascade')->nullable();
            // $table->foreignId('product_variant_dimension_id')->references('id')->on('product_variant_dimensions')->onDelete('cascade')->nullable();

            $table->boolean('cover')->default(0);
            $table->boolean('online')->default(0);

            $table->string('sku')->index();
            $table->double('minimum_quantity')->default(0);
            $table->string('image');
            $table->foreignId('product_variant_state_id')->default(1)->constrained('product_variant_states');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();

            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users');
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->foreign('deleted_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_variants');
    }
};
