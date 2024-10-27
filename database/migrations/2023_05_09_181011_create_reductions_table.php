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
        Schema::create('reductions', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->double('value');
            $table->smallInteger('default')->nullable();
            $table->foreignId('store_id')->nullable()->constrained('stores');
            $table->foreignId('companie_id')->constrained('companies');
            $table->foreignId('state_id')->default(1)->constrained('states');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });

        DB::table('reductions')->insert(array('code'=>'0','name'=>'0%','companie_id'=>1, 'value'=>0,'default'=>1));
        DB::table('reductions')->insert(array('code'=>'10','name'=>'10%','companie_id'=>1, 'value'=>10));
        DB::table('reductions')->insert(array('code'=>'20','name'=>'20%','companie_id'=>1, 'value'=>20));



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reductions');
    }
};
