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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key');
            $table->string('value');
            $table->string('type');
            $table->foreignId('store_id')->nullable()->constrained('stores');
            $table->foreignId('companie_id')->constrained('companies');

            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });

        DB::table('settings')->insert(array('key'=>'currencie_id','value'=>'1','type'=> 'pos','companie_id'=>1 ));


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
};
