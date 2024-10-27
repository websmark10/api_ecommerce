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
        Schema::create('product_variant_dimensions', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->string('ref')->default('');
            $table->foreignId('product_variant_dim_cat_id')->constrained('product_variant_dim_cats');
            $table->foreignId('companie_id')->constrained('companies');
            $table->foreignId('state_id')->default(1)->constrained('states');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users');
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->foreign('deleted_by')->references('id')->on('users');
        });

        DB::table('product_variant_dimensions')->insert(array('companie_id'=> 1,'product_variant_dim_cat_id'=> 1 ,'code'=>'S' ,'name'=>'Chico' ));
        DB::table('product_variant_dimensions')->insert(array('companie_id'=> 1,'product_variant_dim_cat_id'=> 1 ,'code'=>'M' ,'name'=>'Mediano' ));
        DB::table('product_variant_dimensions')->insert(array('companie_id'=> 1,'product_variant_dim_cat_id'=> 1 ,'code'=>'G' ,'name'=>'Grande' ));

        // DB::table('product_variant_dimensions')->insert(array('companie_id'=> 1,'product_variant_dim_cat_id'=> 2 ,'code'=>'KG' ,'name'=>'KG' ));
        // DB::table('product_variant_dimensions')->insert(array('companie_id'=> 1,'product_variant_dim_cat_id'=> 2 ,'code'=>'COS' ,'name'=>'Costal' ));
        // DB::table('product_variant_dimensions')->insert(array('companie_id'=> 1,'product_variant_dim_cat_id'=> 2 ,'code'=>'PZA' ,'name'=>'Pza' ));
        // DB::table('product_variant_dimensions')->insert(array('companie_id'=> 1,'product_variant_dim_cat_id'=> 2 ,'code'=>'DZ' ,'name'=>'Docena' ));

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_variant_dimensions');
    }
};
