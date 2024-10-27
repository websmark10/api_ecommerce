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
        Schema::create('campaigns', function (Blueprint $table) {

            $table->id();
            $table->string('code');
            $table->string('name');
            $table->string('objective');
            $table->foreignId('campaign_type_id')->constrained('campaign_types');
            $table->foreignId('state_id')->default(1)->constrained('states');
            $table->foreignId('companie_id')->constrained('companies');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });

        DB::table('campaigns')->insert(array('code'=>uniqid(), 'name'=>'Campania de Bienvenida',
        'objective'=> 'Fomentar la primer compra','campaign_type_id'=>1 ,'companie_id'=>1));


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('campaigns');
    }
};
