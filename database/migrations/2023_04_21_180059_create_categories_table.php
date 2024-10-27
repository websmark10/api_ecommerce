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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supercategorie_id')->nullable()->constrained('supercategories');
            $table->string('code')->default('');
            $table->string('name');
            $table->string('imagen')->nullable();
            $table->string('icono')->nullable();
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
        DB::table('categories')->insert(array('id'=>'1','name'=>'Sin Categoria','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'99','name'=>'Dieta','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'98','name'=>'Diabetes','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'97','name'=>'Bienestar Sexual','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'96','name'=>'Res','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'95','name'=>'Artículos a granel','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'94','name'=>'Frutas y Verduras Congeladas','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'93','name'=>'Papel higiénico','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'92','name'=>'Hielos y Vasos','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'91','name'=>'Huevo','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'90','name'=>'Digestivos','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'89','name'=>'Blanqueadores','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'88','name'=>'Quitamanchas para Ropa','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'87','name'=>'Lavatrastes y lavavajillas','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'86','name'=>'Enfriadores','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'85','name'=>'Aderezos y Jugos naturales','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'84','name'=>'Accesorios para Limpieza','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'83','name'=>'Café y Té Preparado','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'82','name'=>'Saborizantes y Jarabes','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'81','name'=>'Crema','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'80','name'=>'Comida Fácil','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'79','name'=>'Fórmula láctea','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'78','name'=>'Azúcar y Postres','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'77','name'=>'Pan Salado','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'76','name'=>'Afeitado','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'75','name'=>'Cuidado Personal','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'74','name'=>'Postres Congelados','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'73','name'=>'Higiene del bebé','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'72','name'=>'Empacados','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'71','name'=>'Suavizantes','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'70','name'=>'Verduras','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'7','name'=>'jacket','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'69','name'=>'Alimentos Saludables','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'68','name'=>'Café, Té y Sustitutos','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'67','name'=>'Alimento Líquido','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'66','name'=>'Arroz, Frijol y Semillas','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'65','name'=>'Aromatizantes','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'64','name'=>'Mascotas','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'63','name'=>'Almidón y Colorantes para Ropa','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'62','name'=>'Cereales y Barras','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'61','name'=>'Harina y Repostería','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'60','name'=>'Cuidado Íntimo','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'59','name'=>'Pañales y toallitas húmedas para bebé','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'58','name'=>'Pilas y baterías','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'57','name'=>'Cuidado bucal','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'56','name'=>'Limpieza del hogar','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'55','name'=>'Detergente','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'54','name'=>'Jabón de Lavandería','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'53','name'=>'Quesos','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'52','name'=>'Especias y Sazonadores','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'51','name'=>'Comida oriental','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'50','name'=>'Cuidado de los Pies','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'49','name'=>'Desechables','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'48','name'=>'Pastas','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'47','name'=>'Enlatados y Conservas','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'46','name'=>'Cuidado del cabello','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'45','name'=>'Energizantes e Hidratantes','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'44','name'=>'Vinos','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'43','name'=>'Yogur','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'42','name'=>'Salsas, Aderezos y Vinagre','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'41','name'=>'Leche','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'40','name'=>'Agua','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'39','name'=>'Alimentos Instantáneos','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'38','name'=>'Carnes frías','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'37','name'=>'Mermeladas y Miel','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'36','name'=>'Dulces y Chocolates','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'35','name'=>'Analgésicos','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'34','name'=>'Gelatinas y Postres','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'33','name'=>'Refrescos','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'32','name'=>'Mantequilla y margarina','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'31','name'=>'Comida para bebé y lactancia','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'30','name'=>'Cervezas','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'29','name'=>'Aceites de Cocina','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'28','name'=>'Galletas','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'27','name'=>'Jugos y Néctares','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'26','name'=>'Licores','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'25','name'=>'Higiene y cuidado corporal','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'24','name'=>'Higiene y cuidado para manos','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'23','name'=>'Cuidado facial','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'22','name'=>'Botanas y Fruta Seca','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'21','name'=>'Pan y Tortillas Empacados','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'17','name'=>'tostos','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'16','name'=>'desktop','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'15','name'=>'nm','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'14','name'=>'nn','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'110','name'=>'Vitaminas y Suplementos','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'109','name'=>'Respiratorios','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'108','name'=>'Pañuelos desechables','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'107','name'=>'Oftálmicos y Oticos','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'106','name'=>'Nutrición Deportiva','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'105','name'=>'Medicamentos Infantiles','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'104','name'=>'Medicamentos de Patente','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'103','name'=>'Medicamentos de Alta Especialidad','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'102','name'=>'Material de Curación','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'101','name'=>'Incontinencia','supercategorie_id'=>'1','companie_id'=>1));
        DB::table('categories')->insert(array('id'=>'100','name'=>'Estomacales','supercategorie_id'=>'1','companie_id'=>1));

    /*

SELECT  concat("    DB::table('categories')->insert(array('id'=>'",id,"','name'=>'",name,"','supercategorie_id'=>'1','companie_id'=>1));")  FROM categories
where id not in (1,2,3,4,9,10,11,12,19,20)

 */

    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
};
