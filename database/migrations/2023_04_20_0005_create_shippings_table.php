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
        Schema::create('shippings', function (Blueprint $table) {
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

        DB::table('shippings')->insert(array('code'=>'NEAR','name'=>'<1 km','companie_id'=>1, 'value'=>50));
        DB::table('shippings')->insert(array('code'=>'FARAWAY','name'=>'>1 km','companie_id'=>1, 'value'=>100,'default'=>1));

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shippings');
    }
};
