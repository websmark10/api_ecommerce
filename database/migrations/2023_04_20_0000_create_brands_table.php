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
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->string('imagen');
            $table->string('description')->default('');
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


        DB::table('brands')->insert(array('code'=>'NINGUNA','name'=>'NINGUNA','companie_id'=>1));
        DB::table('brands')->insert(array('code'=>'COCA','name'=>'COCA-COLA','companie_id'=>1));
        DB::table('brands')->insert(array('code'=>'NESTLE','name'=>'NESTLE','companie_id'=>1));
        DB::table('brands')->insert(array('code'=>'BIMBO','name'=>'BIMBO','companie_id'=>1));
        DB::table('brands')->insert(array('code'=>'SONY','name'=>'SONY','companie_id'=>1));
        DB::table('brands')->insert(array('code'=>'HP','name'=>'HP','companie_id'=>1));
        DB::table('brands')->insert(array('code'=>'PANASONIC','name'=>'PANASONIC','companie_id'=>1));
        DB::table('brands')->insert(array('code'=>'CIEL','name'=>'CIEL','companie_id'=>1));
        DB::table('brands')->insert(array('code'=>'ALPURA','name'=>'ALPURA','companie_id'=>1));
        DB::table('brands')->insert(array('code'=>'HUUGGIES','name'=>'HUUGGIES','companie_id'=>1));
        DB::table('brands')->insert(array('code'=>'RICOLINO','name'=>'RICOLINO','companie_id'=>1));


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('brands');
    }
};
