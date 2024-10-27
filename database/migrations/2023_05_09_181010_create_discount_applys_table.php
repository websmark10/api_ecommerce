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
        Schema::create('discount_applys', function (Blueprint $table) {
            $table->id();
            $table->string('code');

            $table->foreignId('state_id')->default(1)->constrained('states');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });

        DB::table('discount_applys')->insert(array('code'=>'Product'));
        DB::table('discount_applys')->insert(array('code'=>'Category'));
        DB::table('discount_applys')->insert(array('code'=>'Brand'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discount_applys');
    }
};