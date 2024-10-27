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
        Schema::create('product_variant_dim_cats', function (Blueprint $table) {
            $table->id();
            $table->string('name');
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

        DB::table('product_variant_dim_cats')->insert(array('name'=>'Tamaño','companie_id'=>1 ));
       // DB::table('product_variant_dim_cats')->insert(array('name'=>'Peso','companie_id'=>1 ));



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_variant_dim_cats');
    }
};
