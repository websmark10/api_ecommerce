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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->foreignId('discount_apply_id')->constrained('discount_applys')->comment('1 Productos | 2 Categoria');
            $table->foreignId('discount_type_id')->constrained('discount_types')->comment('1 Porcentaje | 2 Moneda');
            $table->foreignId('campaign_id')->constrained('campaigns');
            $table->double('discount');
            $table->foreignId('discount_countable_id')->default(1)->constrained('discount_countables')->comment('1 Ilimitado | 2 limitado');
            $table->double('num_use')->default(0);
            $table->timestamp('start_date')->index()->nullable();
            $table->timestamp('end_date')->index()->nullable();
            $table->foreignId('companie_id') ->constrained('companies');
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

        DB::table('coupons')->insert(array('code'=>'bienvenid','campaign_id'=>'1','discount_apply_id'=>'1','discount_type_id'=>'2','discount'=>'20','num_use'=>'5','companie_id'=>1));
        DB::table('coupons')->insert(array('code'=>'venta','campaign_id'=>'1','discount_apply_id'=>'2','discount_type_id'=>'1','discount'=>'100','num_use'=>'0','companie_id'=>1));
        DB::table('coupons')->insert(array('code'=>'gato','campaign_id'=>'1','discount_apply_id'=>'1','discount_type_id'=>'1','discount'=>'10','num_use'=>'2','companie_id'=>1));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupons');
    }
};
