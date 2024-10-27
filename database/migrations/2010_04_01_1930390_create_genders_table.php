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
        Schema::create('genders', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->foreignId('companie_id')->default(1)->constrained('companies');
            $table->foreignId('state_id')->default(1)->constrained('states');
            $table->timestamps();


        });


        DB::table('genders')->insert(array('code'=>'Male'));
        DB::table('genders')->insert(array('code'=>'Female'));
        DB::table('genders')->insert(array('code'=>'Binary'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('genders');
    }
};
