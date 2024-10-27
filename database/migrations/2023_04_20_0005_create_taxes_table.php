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
        Schema::create('taxes', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->integer('rate');
            $table->foreignId('tax_type_id')->constrained('tax_types');
            $table->smallInteger('default')->nullable();
            $table->foreignId('store_id')->nullable()->constrained('stores');
            $table->foreignId('companie_id')->constrained('companies');
            $table->foreignId('state_id')->default(1)->constrained('states');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });

        DB::table('taxes')->insert(array('code'=>'vat@0','rate'=>'0','companie_id'=>1, 'tax_type_id'=>1));
        DB::table('taxes')->insert(array('code'=>'vat@10','rate'=>'10','companie_id'=>1, 'tax_type_id'=>1));
        DB::table('taxes')->insert(array('code'=>'vat@16','rate'=>'16','companie_id'=>1, 'tax_type_id'=>1,'default'=>1));
        DB::table('taxes')->insert(array('code'=>'vat@20','rate'=>'20','companie_id'=>1, 'tax_type_id'=>1));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('taxes');
    }
};
