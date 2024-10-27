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
        Schema::create('product_variant_states', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->foreignId('companie_id')->constrained('companies');
            $table->foreignId('state_id')->default(1)->constrained('states');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });

        DB::table('product_variant_states')->insert(array('code'=>'EnVenta','name'=>'En Venta','companie_id'=>1));
        DB::table('product_variant_states')->insert(array('code'=>'Descontinuado','name'=>'Descontinuado','companie_id'=>1));
        DB::table('product_variant_states')->insert(array('code'=>'Estrategia','name'=>'Estrategia Comercial','companie_id'=>1));

        DB::table('product_variant_states')->insert(array('code'=>'Cancel','name'=>'Estrategia','companie_id'=>1));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_variant_states');
    }
};
