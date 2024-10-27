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
        Schema::create('discount_brands', function (Blueprint $table) {
            $table->id();
            $table->foreignId('discount_id')->constrained('discounts');
            $table->foreignId('brand_id')->constrained('brands');
            $table->foreignId('companie_id') ->constrained('companies');
            $table->timestamps();

            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users');
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->foreign('deleted_by')->references('id')->on('users');
        });


       // DB::table('brands')->insert(array('discount_id'=>'1','brand_id'=>'86'));


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discount_brands');
    }
};
