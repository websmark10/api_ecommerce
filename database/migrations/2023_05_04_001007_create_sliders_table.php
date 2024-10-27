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
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('label')->nullable();
            $table->text('subtitle')->nullable();
            $table->string('imagen');
            $table->string('link')->nullable();
            $table->string('color')->nullable();
            $table->foreignId('slider_type_id')->constrained('slider_types');
            $table->foreignId('companie_id')->constrained('companies');
            $table->foreignId('state_id')->default(1)->constrained('states');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });

        DB::table('sliders')->insert(array('color'=>'#a59bad','title'=>'Rebajas del Buen Fin', 'label'=> 'Aprovecha el invierno','subtitle'=>'Ven y vive los descuentos', 'imagen'=>'buenfin.png', 'link'=>'https://elbuenfin.profeco.gob.mx/','companie_id'=>1,'slider_type_id'=>1));
        DB::table('sliders')->insert(array('color'=>'#a59bad','title'=>'Compra Tus Regalos de Navidad', 'label'=> 'Se acerca diciembre','subtitle'=>'Ven y canta con los villancicos', 'imagen'=>'navidad.png', 'link'=>'https://www.dondeir.com/ciudad/actividades-y-eventos-imperdibles-de-navidad-2023-en-cdmx/2023/11/','companie_id'=>1,'slider_type_id'=>1));

        DB::table('sliders')->insert(array('color'=>'#a59bad','title'=>'Smartphone Apple', 'label'=> 'Descuentos en la linea Apple','subtitle'=>'Modelos smartphone_PNG8501', 'imagen'=>'smartphone.png', 'link'=>'https://www.walmart.com.mx/ip/smartphones/smartphone-cellallure-style-x-3gb-32gb-expandible-4g-b-28-cellallure-style-x-dbx/00454010162272?utm_advertiser=wmea_bing&msclkid=4913554d86de1bacd06233addea09670&utm_source=bing&utm_medium=cpc&utm_campaign=wmea_lf_bing_sitio_conversion_ao_pmax_1p_3p&utm_term=2329040506271730&utm_content=wmea_lf_bing_sitio_conversion_ao_pmax_1p_3p_02-celulares','companie_id'=>1,'slider_type_id'=>2));
        DB::table('sliders')->insert(array('color'=>'#a59bad','title'=>'Medidor de Glucosa Accu-Chek Active', 'label'=> '25 Tiras Reactivas y 25 Lancetas','subtitle'=>'Oferta en Glucómetros', 'imagen'=>'glucosa.png', 'link'=>'https://www.sams.com.mx/material-de-curacion-y-equipo-terapeutico/medidor-de-glucosa-accu-chek-active-con-25-tiras-reactivas-y-25-lancetas/980007714?msclkid=33d455d7d5961ae0b34a33378d2a8f45&utm_source=bing&utm_medium=cpc&utm_campaign=sams_mf_sem_bing_ecomm_performance-max&utm_term=4580290578032525&utm_content=aws-on','companie_id'=>1,'slider_type_id'=>2));

        DB::table('sliders')->insert(array('color'=>'#a59bad','title'=>'cupon Product A', 'label'=> 'hora de  cupones','subtitle'=>'Aprovecha y ahorra', 'imagen'=>'descuentosliderprod.png', 'link'=>'https://www.pngitem.com/middle/hxobmTh_aprovecha-nuestras-promociones-hd-png-download/','companie_id'=>1,'slider_type_id'=>3));
        DB::table('sliders')->insert(array('color'=>'#a59bad','title'=>'Descuento en Producto B', 'label'=> 'Hora de descientos','subtitle'=>'Maximiza tus bolsillos', 'imagen'=>'sliderprodvarios.jpeg', 'link'=>'https://ayudawp.com/porcentaje-descuento-oferta-woocommerce-divi/','companie_id'=>1,'slider_type_id'=>3));



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sliders');
    }
};

