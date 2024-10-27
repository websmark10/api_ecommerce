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
        Schema::create('slider_types', function (Blueprint $table) {

            $table->id();
            $table->string('code');

            $table->foreignId('state_id')->default(1)->constrained('states');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });

        DB::table('slider_types')->insert(array('code'=>'Main'));
        DB::table('slider_types')->insert(array('code'=>'Secundary'));
        DB::table('slider_types')->insert(array('code'=>'Product'));

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('slider_types');
    }
};
