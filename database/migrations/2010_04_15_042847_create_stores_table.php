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
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address')->default('');
            $table->string('phone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('url_lan_printer')->nullable();
            $table->string('url_printer')->nullable();
            $table->string('country_id')->default('1');
            $table->string('google_maps')->default('');
            $table->foreignId('companie_id')->constrained('companies');
            $table->foreignId('state_id')->default(1)->constrained('states');
            $table->smallInteger('main')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users');
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->foreign('deleted_by')->references('id')->on('users');
        });

        DB::table('stores')->insert(array('name'=>'Sucursal Tepalcates','companie_id'=>1, 'main'=>'1', 'google_maps'=>'https://www.google.com/maps/place/Jugos+y+licuados/@19.3889363,-99.0552999,3a,75y,101.48h,94.28t/data=!3m6!1e1!3m4!1s_dBvM7RFspwgzsE6r2GRxw!2e0!7i16384!8i8192!4m6!3m5!1s0x85d1fdc1fbd8d1cf:0xb84b0f40cb29a9!8m2!3d19.3892245!4d-99.055132!16s%2Fg%2F11ng6ghmp0?entry=ttu' ));
        DB::table('stores')->insert(array('name'=>'Sucursal San Juan','companie_id'=>2,  'google_maps'=>'https://www.google.com/maps/place/Mercado+de+San+Juan+Pugibet/@19.4299327,-99.2971338,12z/data=!4m10!1m2!2m1!1smercado+de+san+juan!3m6!1s0x85d1fed5751e25c5:0xa20f8063034c8134!8m2!3d19.4299327!4d-99.1446985!15sChNtZXJjYWRvIGRlIHNhbiBqdWFuWhUiE21lcmNhZG8gZGUgc2FuIGp1YW6SARFmcmVzaF9mb29kX21hcmtldJoBJENoZERTVWhOTUc5blMwVkpRMEZuU1VSdGQzVTJPRjluUlJBQuABAA!16s%2Fg%2F11c1xl_wrv?entry=ttu' ));


        DB::table('stores')->insert(array('name'=>'Bodega Tepalcates','companie_id'=>2,  'main'=>'1', 'google_maps'=>'https://www.google.com/maps/place/Bodega+Aurrera,+Zaragoza/@19.396874,-99.0625757,16z/data=!4m10!1m2!2m1!1saurrera+Tepalcates!3m6!1s0x85d1fcfdd15b1a41:0xdbb7b6eca45f4e85!8m2!3d19.3928873!4d-99.0510079!15sChJhdXJyZXJhIFRlcGFsY2F0ZXMiA4gBAVoUIhJhdXJyZXJhIHRlcGFsY2F0ZXOSAQtzdXBlcm1hcmtldOABAA!16s%2Fg%2F1td0ytqy?entry=ttu' ));
        DB::table('stores')->insert(array('name'=>'Bodega Pantitlán','companie_id'=>2,  'google_maps'=>'https://www.google.com/maps/place/Bodega+Aurrera,+Pantitl%C3%A1n/@19.4008407,-99.0706767,16z/data=!4m10!1m2!2m1!1saurrera+Tepalcates!3m6!1s0x85d1fc576eb2629d:0x8d4b780d98126415!8m2!3d19.4008407!4d-99.0611495!15sChJhdXJyZXJhIFRlcGFsY2F0ZXMiA4gBAVoUIhJhdXJyZXJhIHRlcGFsY2F0ZXOSAQtzdXBlcm1hcmtldOABAA!16s%2Fg%2F1tfmcl0b?entry=ttu' ));



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stores');
    }
};
