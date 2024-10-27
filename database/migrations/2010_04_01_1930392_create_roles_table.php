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
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->foreignId('user_type_id')->constrained('user_types')->comment(' 1 Sistema de Administración | 2 Sistema Ecommerce ');
            $table->foreignId('companie_id')->constrained('companies');
            $table->foreignId('state_id')->default(1)->constrained('states');
            $table->timestamps();
        });

        DB::table('roles')->insert(array('code'=>'Client','user_type_id'=> 2 ,'companie_id'=>1));
        DB::table('roles')->insert(array('code'=>'Programmer','user_type_id'=> 1 ,'companie_id'=>1));
        DB::table('roles')->insert(array('code'=>'Administrador','user_type_id'=> 1 ,'companie_id'=>1));
        DB::table('roles')->insert(array('code'=>'Sales','user_type_id'=> 1 ,'companie_id'=>1));
        DB::table('roles')->insert(array('code'=>'Inventory','user_type_id'=> 1 ,'companie_id'=>1));
        DB::table('roles')->insert(array('code'=>'Resports','user_type_id'=> 1 ,'companie_id'=>1));


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
};
