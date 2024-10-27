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
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
           $table->string('code');
            $table->string('name');
            $table->string('symbol');
            $table->double('exchange_rate');
            $table->boolean('default')->default(0);
            $table->foreignId('store_id')->nullable()->constrained('stores');
            $table->foreignId('companie_id')->default(1)->constrained('companies');
            $table->timestamps();
        });

        DB::table('currencies')->insert(array('code'=>'USD','name'=>'USD Dollar','symbol'=>'US$', 'exchange_rate'=>0.054000667,'companie_id'=> 1 ,'default'=>0));
        DB::table('currencies')->insert(array('code'=>'MXN','name'=>'PESOS',     'symbol'=>'$', 'exchange_rate'=>1,'companie_id'=> 1  ,'default'=>1));
        DB::table('currencies')->insert(array('code'=>'EUR','name'=>'Euro',      'symbol'=>'€', 'exchange_rate'=>0.050270233,'companie_id'=> 1  ,'default'=>0));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('currencies');
    }
};
