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
        Schema::create('inventory', function (Blueprint $table) {

            $table->id();
            $table->foreignId('batch_id')->constrained('batches')->nullable();
         //   $table->foreignId('inventory_source_id')->constrained('inventory_sources');
            $table->foreignId('product_id')->constrained('products');
            $table->foreignId('inventory_source_id')->constrained('inventory_sources');
            $table->foreignId('product_variant_id')->constrained('product_variants')->onDelete('cascade');;
            $table->foreignId('store_id')->constrained('stores');
            $table->foreignId('provider_id')->constrained('providers');
            $table->integer('stock');
            $table->date('manufactured_date')->nullable();
            $table->date('expiry_date')->index()->nullable();
            $table->double('price');
            $table->double('cost')->nullable();
            $table->integer('sold')->default(0);
            $table->integer('available')->index()->nullable();


            $table->foreignId('companie_id') ->constrained('companies');
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
        Schema::dropIfExists('inventory');
    }
};
