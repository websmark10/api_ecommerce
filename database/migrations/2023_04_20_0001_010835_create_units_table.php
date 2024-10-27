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
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->tinyInteger('base_unit');
            $table->string('operator');
            $table->tinyInteger('value');
            $table->foreignId('companie_id')->constrained('companies');
            $table->foreignId('state_id')->default(1)->constrained('states');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });

        DB::table('units')->insert(array('code'=>'pza','name'=>'Pieza','base_unit'=>'1','operator'=>'*','value'=>'1','companie_id'=>1));
        DB::table('units')->insert(array('code'=>'dozen','name'=>'Docena','base_unit'=>'1','operator'=>'*','value'=>'12','companie_id'=>1));
        DB::table('units')->insert(array('code'=>'kg','name'=>'Kilogramo','base_unit'=>'1','operator'=>'*','value'=>'1','companie_id'=>1));

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('units');
    }
};
