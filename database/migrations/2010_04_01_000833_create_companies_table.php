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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->string('logo');
            $table->string('slogan');
            $table->string('description')->default('');
            $table->foreignId('state_id')->default(1)->constrained('states');

            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
           // $table->unsignedBigInteger('created_by')->nullable();
            //$table->foreign('created_by')->references('id')->on('users');
           // $table->unsignedBigInteger('updated_by')->nullable();
           // $table->foreign('updated_by')->references('id')->on('users');
           // $table->unsignedBigInteger('deleted_by')->nullable();
           // $table->foreign('deleted_by')->references('id')->on('users');
        });

        DB::table('companies')->insert(array('code'=>'MIDESPENSA', 'name'=>'Mi Despensa', 'logo'=>'logo.png','slogan'=>'Compra todo tu super en un mismo lugar'));
        DB::table('companies')->insert(array( 'code'=>'AURRERA','name'=>'Aurrera', 'logo'=>'logo.png','slogan'=>'Compra todo tu super en un mismo lugar'));


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
};
