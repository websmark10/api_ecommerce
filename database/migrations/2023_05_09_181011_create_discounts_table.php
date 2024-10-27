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
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->foreignId('discount_apply_id')->constrained('discount_applys');
            $table->foreignId('discount_type_id')->constrained('discount_types');
            $table->foreignId('discount_method_id')->constrained('discount_methods');
            // $table->tinyInteger('type_id')->default(1)->comment('1 Productos | 2 Categoria');
            // $table->tinyInteger('type_discount_id')->default(1)->comment('1 Porcentaje | 2 Moneda');
            $table->double('discount')->index();

            $table->foreignId('campaign_id')->constrained('campaigns');
            $table->timestamp('start_date')->index()->nullable();
            $table->timestamp('end_date')->index()->nullable();
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

        // DB::table('discounts')->insert(array('code'=>'645aa4b2a8d05', 'companie_id'=> 1 , 'discount_apply_id'=>'2','discount_type_id'=>'1','discount'=>'50','start_date'=>'2023-01-01 14:42:37', 'end_date'=>'2025-05-01 14:42:37','discount_method_id'=>1,'campaign_id'=>1));
        // DB::table('discounts')->insert(array('code'=>'645aad17e9c5c', 'companie_id'=> 1 ,'discount_apply_id'=>'1','discount_type_id'=>'2','discount'=>'10','start_date'=>'2023-01-01 14:42:37', 'end_date'=>'2025-05-01 14:42:37','discount_method_id'=>1,'campaign_id'=>1));


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discounts');
    }
};
