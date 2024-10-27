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
        Schema::create('product_specifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreignId('cat_attribute_id')->nullable() ->constrained('product_variant_attr_cats');
            $table->foreignId('attribute_id')->nullable() ->constrained('product_variant_attributes');
          //  $table->foreignId('product_variant_dimension_id')->nullable() ->constrained('product_variant_dimensions');
            $table->string('value');
            $table->foreignId('state_id')->default(1)->constrained('states');
            $table->foreignId('companie_id') ->constrained('companies');
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
        Schema::dropIfExists('product_specifications');
    }
};
