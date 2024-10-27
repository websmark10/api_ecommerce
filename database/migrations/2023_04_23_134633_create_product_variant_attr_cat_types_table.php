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
        Schema::create('product_variant_attr_cat_types', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->foreignId('state_id')->default(1)->constrained('states');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
      });

        DB::table('product_variant_attr_cat_types')->insert(array('code'=>'Text'));
        DB::table('product_variant_attr_cat_types')->insert(array('code'=>'Numeric'));
        DB::table('product_variant_attr_cat_types')->insert(array('code'=>'SelectOne'));
        DB::table('product_variant_attr_cat_types')->insert(array('code'=>'SelectMultiple'));


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_variant_attr_cat_types');
    }
};
