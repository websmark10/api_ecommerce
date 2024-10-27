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
        Schema::create('product_variant_attributes', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->string('ref')->default('');
            $table->foreignId('product_variant_attr_cat_id')->constrained('product_variant_attr_cats');
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

        DB::table('product_variant_attributes')->insert(array('companie_id'=> 1,'product_variant_attr_cat_id'=> 1  ,'code'=>'Dia', 'name'=>'Dia', 'ref'=>''));
        DB::table('product_variant_attributes')->insert(array('companie_id'=> 1,'product_variant_attr_cat_id'=> 1  ,'code'=>'Semana', 'name'=>'Semana', 'ref'=>''));
        DB::table('product_variant_attributes')->insert(array('companie_id'=> 1,'product_variant_attr_cat_id'=> 1  ,'code'=>'Mes','name'=>'Mes', 'ref'=>''));

        DB::table('product_variant_attributes')->insert(array('companie_id'=> 1,'product_variant_attr_cat_id'=> 2  , 'ref'=>10));
        DB::table('product_variant_attributes')->insert(array('companie_id'=> 1,'product_variant_attr_cat_id'=> 2  , 'ref'=>100));
        DB::table('product_variant_attributes')->insert(array('companie_id'=> 1,'product_variant_attr_cat_id'=> 2  , 'ref'=>1000));

        DB::table('product_variant_attributes')->insert(array('companie_id'=> 1,'product_variant_attr_cat_id'=> 3  ,'code'=>'Verde', 'name'=>'Verde', 'ref'=>'#DAF7A6'));
        DB::table('product_variant_attributes')->insert(array('companie_id'=> 1,'product_variant_attr_cat_id'=> 3  ,'code'=>'Rojo', 'name'=>'Rojo', 'ref'=>'#FF5733'));
        DB::table('product_variant_attributes')->insert(array('companie_id'=> 1,'product_variant_attr_cat_id'=> 3  ,'code'=>'Azul','name'=>'Azul', 'ref'=>'#338DFF'));
        DB::table('product_variant_attributes')->insert(array('companie_id'=> 1,'product_variant_attr_cat_id'=> 3  ,'code'=>'Blanco' ,'name'=>'Blanco', 'ref'=>'#FFFDFF'));
        DB::table('product_variant_attributes')->insert(array('companie_id'=> 1,'product_variant_attr_cat_id'=> 3  ,'code'=>'Negro', 'name'=>'Negro', 'ref'=>'#000000'));

        DB::table('product_variant_attributes')->insert(array('companie_id'=> 1,'product_variant_attr_cat_id'=> 4  ,'code'=>'200 gb', 'name'=>'200 gb', 'ref'=>''));
        DB::table('product_variant_attributes')->insert(array('companie_id'=> 1,'product_variant_attr_cat_id'=> 4  ,'code'=>'300 gb', 'name'=>'300 gb', 'ref'=>''));
        DB::table('product_variant_attributes')->insert(array('companie_id'=> 1,'product_variant_attr_cat_id'=> 4  ,'code'=>'500 gb','name'=>'500 gb', 'ref'=>''));
        DB::table('product_variant_attributes')->insert(array('companie_id'=> 1,'product_variant_attr_cat_id'=> 4  ,'code'=>'1 tera' ,'name'=>'1 tera', 'ref'=>''));


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_variant_attributes');
    }
};
