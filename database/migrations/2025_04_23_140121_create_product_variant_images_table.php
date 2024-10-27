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
        Schema::create('product_variant_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_variant_id')->constrained('product_variants') ->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products');
            $table->foreignId('companie_id')->constrained('companies');
            $table->string('name');
            $table->string('type');
            $table->string('size');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
/*
        DB::table('product_variant_images')->insert(array('product_id'=>'4','product_variant_id'=>'4','companie_id'=>1,'name'=> '1.jpg' ));
        DB::table('product_variant_images')->insert(array('product_id'=>'4','product_variant_id'=>'4','companie_id'=>1,'name'=> '2.jpg' ));
        DB::table('product_variant_images')->insert(array('product_id'=>'4','product_variant_id'=>'4','companie_id'=>1,'name'=> '3.jpg' ));
        DB::table('product_variant_images')->insert(array('product_id'=>'4','product_variant_id'=>'4','companie_id'=>1,'name'=> '4.jpg' ));
        DB::table('product_variant_images')->insert(array('product_id'=>'4','product_variant_id'=>'4','companie_id'=>1,'name'=> '5.jpg' ));


        DB::table('product_variant_images')->insert(array('product_id'=>'5','product_variant_id'=>'5','companie_id'=>1,'name'=> '1.jpg' ));
        DB::table('product_variant_images')->insert(array('product_id'=>'5','product_variant_id'=>'5','companie_id'=>1,'name'=> '2.jpg' ));
        DB::table('product_variant_images')->insert(array('product_id'=>'5','product_variant_id'=>'5','companie_id'=>1,'name'=> '3.jpg' ));

        DB::table('product_variant_images')->insert(array('product_id'=>'5','product_variant_id'=>'6','companie_id'=>1,'name'=> '1.jpg' ));
        DB::table('product_variant_images')->insert(array('product_id'=>'5','product_variant_id'=>'6','companie_id'=>1,'name'=> '2.jpg' ));
        DB::table('product_variant_images')->insert(array('product_id'=>'5','product_variant_id'=>'6','companie_id'=>1,'name'=> '3.jpg' ));


        DB::table('product_variant_images')->insert(array('product_id'=>'5','product_variant_id'=>'7','companie_id'=>1,'name'=> '1.jpg' ));
        DB::table('product_variant_images')->insert(array('product_id'=>'5','product_variant_id'=>'7','companie_id'=>1,'name'=> '2.jpg' ));
        DB::table('product_variant_images')->insert(array('product_id'=>'5','product_variant_id'=>'7','companie_id'=>1,'name'=> '3.jpg' ));

        DB::table('product_variant_images')->insert(array('product_id'=>'5','product_variant_id'=>'8','companie_id'=>1,'name'=> '1.jpg' ));
        DB::table('product_variant_images')->insert(array('product_id'=>'5','product_variant_id'=>'8','companie_id'=>1,'name'=> '2.jpg' ));
        DB::table('product_variant_images')->insert(array('product_id'=>'5','product_variant_id'=>'8','companie_id'=>1,'name'=> '3.jpg' ));

        DB::table('product_variant_images')->insert(array('product_id'=>'5','product_variant_id'=>'9','companie_id'=>1,'name'=> '1.jpg' ));
        DB::table('product_variant_images')->insert(array('product_id'=>'5','product_variant_id'=>'9','companie_id'=>1,'name'=> '2.jpg' ));
        DB::table('product_variant_images')->insert(array('product_id'=>'5','product_variant_id'=>'9','companie_id'=>1,'name'=> '3.jpg' ));
*/

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_variant_images');
    }
};
