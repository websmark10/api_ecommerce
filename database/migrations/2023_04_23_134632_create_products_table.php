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
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->foreignId('subcategorie_id')->constrained('subcategories');
            $table->foreignId('brand_id')->constrained('brands');
            $table->foreignId('unit_id')->constrained('units');
            $table->foreignId('tax_id')->constrained('taxes');
            $table->string('title')->index();
            $table->string('slug');
            //$table->string('sku');

           // $table->double('price_usd');
            $table->longText('tags'); //json
            $table->longText('description')->default('');
            $table->string('summary');
           // $table->tinyInteger('state_id')->unsigned()->default(1)->comment('1 en demo , 2 público, 3 bloqueado');
           $table->smallInteger('online')->default('1');
           // $table->string('imagen');
            /*Segun la Sucursal */
           // $table->double('minimum_quantity')->default(0);
           //  $table->double('price');
           //  $table->double('stock')->nullable();


          /*Sefun el inventario */
            // Manufactured
            // Expiry

            // $table->foreignId('prodstate_id')->default(1)->constrained('product_variant_states');
            $table->foreignId('companie_id')->default(1)->constrained('companies');
            $table->foreignId('state_id')->default(1)->constrained('states');
            //$table->tinyInteger('state_id')->unsigned()->default(1)->comment('1 Inventario Individual, 2 Inventario Múltiple');
            $table->foreignId('inventory_type_id')->constrained('inventory_types')->default(1)->comment('1 Individual  | 2 Multiple  ');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();

            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users');
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->foreign('deleted_by')->references('id')->on('users');

        });
        
        /*
        DB::table('products')->insert(array('subcategorie_id'=>'1',    'brand_id'=>'1',
        'unit_id'=>'1',    'tax_id'=>'1',    'title'=>'Tomate Saladet por kg',    'slug'=>'tomate-saladet-por-kg',    'sku'=>'3102861',    'price'=>'17.9',    'price_usd'=>'0.5',    'tags'=>'verduras,super',    'description'=>'',    'resumen'=>'Tomate Saladet por kilo. Para una dieta más saludable.','description'=>'<p>Las verduras, son un complemento necesario para la comida diaria, ya que aportan una gran variedad de nutrientes que tu cuerpo necesita. Las verduras contribuyen con vitaminas y minerales, adem&aacute;s de proporcionar agua al cuerpo. Tambi&eacute;n contienen fibra, antioxidantes y algunas de ellas un alto contenido en potasio lo que te ayuda a eliminar el exceso de l&iacute;quidos en el cuerpo.</p>',    'state_id'=>'1',    'imagen'=>'productos/nM2kCGMEt1u1yqgvOlwvguC4eiqmgR2HOEQs17sb.webp',    'stock'=>'2',    'state_id'=>'1',    'inventory_type_id'=>'1'));
       DB::table('products')->insert(array('subcategorie_id'=>'1',    'brand_id'=>'1',
        'unit_id'=>'1',    'tax_id'=>'1',    'title'=>'Limón sin Semilla por kilo.',    'slug'=>'limon-sin-semilla-por-kilo',    'sku'=>'3102776',    'price'=>'48',    'price_usd'=>'3',    'tags'=>'fruta,super',    'description'=>'',    'resumen'=>'Limón sin Semilla por kilo. Perfecto para una alimentación más balanceada.','description'=>'<p>Comer todos los d&iacute;as frutas, ayuda a tener un cuerpo y mente sana. Las frutas tienen una infinidad de beneficios como su alto contenido en vitaminas, minerales, fibra y agua org&aacute;nica. Comer una fruta despu&eacute;s de la comida, te proporcionara energ&iacute;a para terminar el d&iacute;a gracias a su az&uacute;car natural. Es ideal como postre, en el lunch de los ni&ntilde;os. Tambi&eacute;n su consumo ayuda a aumentar las defensas y favorece la cicatrizaci&oacute;n de la piel.&nbsp;</p>',    'state_id'=>'1',    'imagen'=>'productos/thT49IpI4QBL623Pio8Vbh5jTItFvi81P67PNJgq.webp',    'stock'=>'20',    'state_id'=>'1',    'inventory_type_id'=>'1'));
       DB::table('products')->insert(array('subcategorie_id'=>'1',    'brand_id'=>'1',
        'unit_id'=>'1',    'tax_id'=>'1',    'title'=>'Lavadora Mabe Aqua Saver Green 16kg Blanca',    'slug'=>'lavadora-mabe-aqua-saver-green-16kg-blanca',    'sku'=>'3586543',    'price'=>'6795',    'price_usd'=>'400',    'tags'=>'lavadora,mabe',    'description'=>'',    'resumen'=>'Lavadora Mabe Aqua Saver green 16 K g. Blanca','description'=>'<p class="chedrauimx-chedraui-cms-components-2-x-descriptionAdditional">Lavadora Mabe Aqua Saver Green 16 Kg Blanca</p>
      <p><br /><span class="chedrauimx-chedraui-cms-components-2-x-titleDescription">Caracter&iacute;sticas Importantes</span></p>
      <ul class="chedrauimx-chedraui-cms-components-2-x-descriptionList">
      <li class="chedrauimx-chedraui-cms-components-2-x-listElement">Ahorra agua y cuida el planeta , gracias a la tecnolog&iacute;a Aqua Saver Green.</li>
      <li class="chedrauimx-chedraui-cms-components-2-x-listElement">Sistema de lavado infusor Aqua energy roller que mejora el movimiento de la ropa dando una m&aacute;xima limpieza y evitando el enredo.</li>
      <li class="chedrauimx-chedraui-cms-components-2-x-listElement">Lavado express que permite tener ropa limpia en tan solo 20 minutos.</li>
      </ul>',    'state_id'=>'1',    'imagen'=>'productos/f8gsZ3JW3v78Xkf3W3vz4Ib0poFbnzlS0RwIs2jv.webp',    'stock'=>'5',    'state_id'=>'1',    'inventory_type_id'=>'1'));
       DB::table('products')->insert(array('subcategorie_id'=>'1',    'brand_id'=>'1',
        'unit_id'=>'1',    'tax_id'=>'1',    'title'=>'Laptop Lenovo IP3 Pentium Silver 8GB RAM 256 SSD 14 Pulgadas HD Negra',    'slug'=>'laptop-lenovo-ip3-pentium-silver-8gb-ram-256-ssd-14-pulgadas-hd-negra',    'sku'=>'3770860',    'price'=>'7995',    'price_usd'=>'410',    'tags'=>'laptop',    'description'=>'',    'resumen'=>'Rendimiento crucial. Procesamiento hasta Intel Pentium de 11va. Pantalla de 14 pulgadas FHD antirreflejos, Grandes opciones de memoria y almacenamiento. Para no perder el ritmo en el trabajo ni en el estudio. Perfecta para tus momentos de ocio y diversión','description'=>'<p class="chedrauimx-chedraui-cms-components-2-x-descriptionAdditional">Laptop Lenovo IP3 Pentium Silver 8GB RAM 256 SSD 14 Pulgadas HD Negra</p>
      <p><br /><span class="chedrauimx-chedraui-cms-components-2-x-titleDescription">Caracter&iacute;sticas Importantes</span></p>
      <ul class="chedrauimx-chedraui-cms-components-2-x-descriptionList">
      <li class="chedrauimx-chedraui-cms-components-2-x-listElement">Procesador Intel Pentium Silver N5030 (4C / 4T, 1.1 / 3.1GHz, 4MB)</li>
      <li class="chedrauimx-chedraui-cms-components-2-x-listElement">Pantalla de 14 pulgadasFHD</li>
      <li class="chedrauimx-chedraui-cms-components-2-x-listElement">14 pulgadas</li>
      <li class="chedrauimx-chedraui-cms-components-2-x-listElement">Memoria 256SSD</li>
      <li class="chedrauimx-chedraui-cms-components-2-x-listElement">Memoria RAM 8GB</li>
      </ul>',    'state_id'=>'1',    'imagen'=>'productos/54NGpCJVTLxKm6VJD7T3ElZ0QTpAK7AUVNZVVMxO.webp',    'stock'=>'3',    'state_id'=>'1',    'inventory_type_id'=>'1'));
       DB::table('products')->insert(array('subcategorie_id'=>'1',    'brand_id'=>'1',
        'unit_id'=>'1',    'tax_id'=>'1',    'title'=>'Celular Hisense V50 64GB Azul Desbloqueado',    'slug'=>'celular-hisense-v50-64gb-azul-desbloqueado',    'sku'=>'3718934',    'price'=>'4499',    'price_usd'=>'200',    'tags'=>'celular',    'description'=>'',    'resumen'=>'El smartphone Hisense V50 está diseñado para caber cómodamente en tu mano ya que las curvas de su cuerpo texturizado en diseño 3D, se complementan con un acabado suave y cómodo que se disfruta al manipularlo. Con esta pantalla de 6.55 pulgadas tienes una vista más amplia y envolvente, disfruta de imágenes coloridas en juegos y videos en todo momento, mayor experiencia de visualización. Sé un fotógrafo profesional y toma las mejores fotografías con sus dos cámaras traseras de 13MP+2MP y para una selfie perfecta, captura tu mejor sonrisa con la cámara frontal de 5 MP, sin importar en donde estés y con cualquier luz. El smartphone Hisense cuenta con 4550 mAh que te rinde para ver los videos que quieras, navegar en internet sin preocupaciones y participar en los mejores juegos en línea.','description'=>'<p class="chedrauimx-chedraui-cms-components-2-x-descriptionAdditional">A tu alcance la inteligencia artificial con cuatro c&aacute;maras</p>
      <p><br /><span class="chedrauimx-chedraui-cms-components-2-x-titleDescription">Caracter&iacute;sticas Importantes</span></p>
      <ul class="chedrauimx-chedraui-cms-components-2-x-descriptionList">
      <li class="chedrauimx-chedraui-cms-components-2-x-listElement">Pantalla 720 x 1600 p&iacute;xeles, 6.55 pulgadas</li>
      <li class="chedrauimx-chedraui-cms-components-2-x-listElement">C&aacute;mara frontal 5MP, C&aacute;mara trasera 13+2MP</li>
      <li class="chedrauimx-chedraui-cms-components-2-x-listElement">Sistema Operativo Android 11</li>
      </ul>',    'state_id'=>'1',    'imagen'=>'productos/7gIYFPCdZlRi1D5nrsc1ozuAhonLpSqiuxF7FoiW.webp',    'stock'=>'5',    'state_id'=>'1',    'inventory_type_id'=>'1'));
       DB::table('products')->insert(array('subcategorie_id'=>'1',    'brand_id'=>'1',
        'unit_id'=>'1',    'tax_id'=>'1',    'title'=>'Refresco Sangria Señorial Light 600ml',    'slug'=>'refresco-sangria-senorial-light-600ml',    'sku'=>'7500326103360',    'price'=>'18.8',    'price_usd'=>'1',    'tags'=>'Refresco',    'description'=>'',    'resumen'=>'Refresco elaborado sin azucar, ideal para disfrutar sin remordimientos. En practico envase PET no retornable. Tomala bien fria! Disponible tambien en presentacion individual de 1 lt','description'=>'<p class="chedrauimx-chedraui-cms-components-2-x-descriptionAdditional">Refrescante bebida sabor a Sangr&iacute;a, para disfrutar con toda la familia</p>
      <p><br /><span class="chedrauimx-chedraui-cms-components-2-x-titleDescription">Caracter&iacute;sticas Importantes</span></p>
      <ul class="chedrauimx-chedraui-cms-components-2-x-descriptionList">
      <li class="chedrauimx-chedraui-cms-components-2-x-listElement">Producto de nostalgia, recordado por todas las generaciones.</li>
      <li class="chedrauimx-chedraui-cms-components-2-x-listElement">Se puede mezclar con alimentos y bebidas</li>
      <li class="chedrauimx-chedraui-cms-components-2-x-listElement">Delicioso sabor a Sangr&iacute;a</li>
      <li class="chedrauimx-chedraui-cms-components-2-x-listElement">Ideal para toda la familia</li>
      </ul>',    'state_id'=>'1',    'imagen'=>'productos/1rSHMbshMuRZkhZtxMqrhIcYFe4GG3PCzXY2FimS.webp',    'stock'=>'6',    'state_id'=>'1',    'inventory_type_id'=>'1'));
       DB::table('products')->insert(array('subcategorie_id'=>'1',    'brand_id'=>'1',
        'unit_id'=>'1',    'tax_id'=>'1',    'title'=>'Gatorade Ponche 1L',    'slug'=>'gatorade-ponche-1l',    'sku'=>'036731326003',    'price'=>'20.5',    'price_usd'=>'1',    'tags'=>'bebidas',    'description'=>'',    'resumen'=>'Prepara tu despensa en unos cuantos clics y descubre nuestra gran variedad de productos. ¡No salgas de casa, nosotros te llevamos el súper!','description'=>'<p class="chedrauimx-chedraui-cms-components-2-x-descriptionAdditional">Gatorade Ponche 1L</p>
      <p><br /><span class="chedrauimx-chedraui-cms-components-2-x-titleDescription">Caracter&iacute;sticas Importantes</span></p>
      <ul class="chedrauimx-chedraui-cms-components-2-x-descriptionList">
      <li class="chedrauimx-chedraui-cms-components-2-x-listElement">Ayuda a reponer los electrolitos que pierdes al sudar</li>
      <li class="chedrauimx-chedraui-cms-components-2-x-listElement">Con un sabor intenso</li>
      <li class="chedrauimx-chedraui-cms-components-2-x-listElement">Contiene la mezcla de carbohidratos ideal para mejorar tu rendimiento durante la realizaci&oacute;n de ejercicio</li>
      </ul>',    'state_id'=>'1',    'imagen'=>'productos/u4sUgkmyAaE9b0ltltPkeyDLrNJhXO4dX7pautxT.jpg',    'stock'=>'7',    'state_id'=>'1',    'inventory_type_id'=>'1'));
       DB::table('products')->insert(array('subcategorie_id'=>'1',    'brand_id'=>'1',
        'unit_id'=>'1',    'tax_id'=>'1',    'title'=>'Bebida de Fruta Valle Frut Citrus Punch 3L',    'slug'=>'bebida-de-fruta-valle-frut-citrus-punch-3l',    'sku'=>'7501055330812',    'price'=>'31.5',    'price_usd'=>'2',    'tags'=>'Bebidas',    'description'=>'',    'resumen'=>'Disfruta del delicioso sabor de Del Valle Frut Citrus Punch, una explosión cítrica que te refrescará por completo. Una bebida ideal para acompañar tus comidas y disfrutar en un día caluroso. Bebida no carbonatada, con jugo de fruta. Presentación 3lt.','description'=>'<p class="chedrauimx-chedraui-cms-components-2-x-descriptionAdditional">Bebida frutal sabor naranja con 2% de jugo fortificado con vitaminas Valle Frut 3L botella PET</p>
      <p><br /><span class="chedrauimx-chedraui-cms-components-2-x-titleDescription">Caracter&iacute;sticas Importantes</span></p>
      <ul class="chedrauimx-chedraui-cms-components-2-x-descriptionList">
      <li class="chedrauimx-chedraui-cms-components-2-x-listElement">Bebida con jugo de fruta</li>
      <li class="chedrauimx-chedraui-cms-components-2-x-listElement">Bebidas de Fruta</li>
      <li class="chedrauimx-chedraui-cms-components-2-x-listElement">Fortificada con vitaminas A y B1</li>
      </ul>',    'state_id'=>'1',    'imagen'=>'productos/4JHm3zLUmRSeIGiGROu3rplVQ4kRxl2eAJkpHgvr.webp',    'stock'=>'89',    'state_id'=>'1',    'inventory_type_id'=>'1'));
       DB::table('products')->insert(array('subcategorie_id'=>'1',    'brand_id'=>'1',
        'unit_id'=>'1',    'tax_id'=>'1',    'title'=>'Refresco Manzanita Sol 400ml',    'slug'=>'refresco-manzanita-sol-400ml',    'sku'=>'7501031302802',    'price'=>'9.5',    'price_usd'=>'0.5',    'tags'=>'bebida,manzana',    'description'=>'',    'resumen'=>'Prepara tu despensa en unos cuantos clics y descubre nuestra gran variedad de productos. ¡No salgas de casa, nosotros te llevamos el súper!','description'=>'<p class="chedrauimx-chedraui-cms-components-2-x-descriptionAdditional">Manzanita Sol es un refresco con jugo de manzana, con un sabor y aroma irresistibles.</p>
      <p><br /><span class="chedrauimx-chedraui-cms-components-2-x-titleDescription">Caracter&iacute;sticas Importantes</span></p>
      <ul class="chedrauimx-chedraui-cms-components-2-x-descriptionList">
      <li class="chedrauimx-chedraui-cms-components-2-x-listElement">Hidrataci&oacute;n.</li>
      <li class="chedrauimx-chedraui-cms-components-2-x-listElement">Gran sabor e irresistible aroma</li>
      <li class="chedrauimx-chedraui-cms-components-2-x-listElement">Bebida Carbonatada</li>
      </ul>',    'state_id'=>'1',    'imagen'=>'productos/FYajeLjsPMDUMQXiFn3JVQumV6kCKLKwcrDwMyNE.webp',    'stock'=>'9',    'state_id'=>'1',    'inventory_type_id'=>'1'));
       DB::table('products')->insert(array('subcategorie_id'=>'1',    'brand_id'=>'1',
        'unit_id'=>'1',    'tax_id'=>'1',    'title'=>'Toallitas Húmedas para Bebé Chicolastic Classic 80 Toallitas',    'slug'=>'toallitas-humedas-para-bebe-chicolastic-classic-80-toallitas',    'sku'=>'3637233',    'price'=>'21.85',    'price_usd'=>'1',    'tags'=>'toallitas',    'description'=>'',    'resumen'=>'Las toallitas húmedas Chicolastic Classic combinan suavidad y resistencia gracias a su tela con fibras de algodón. Su fórmula contiene emolientes como manzanilla, aloe y vitamina E que ayudan a proteger la piel.','description'=>'<p class="chedrauimx-chedraui-cms-components-2-x-descriptionAdditional">Las toallitas h&uacute;medas Chicolastic Classic combinan suavidad y resistencia gracias a su tela con fibras de algod&oacute;n.</p>
      <p><br /><span class="chedrauimx-chedraui-cms-components-2-x-titleDescription">Caracter&iacute;sticas Importantes</span></p>
      <ul class="chedrauimx-chedraui-cms-components-2-x-descriptionList">
      <li class="chedrauimx-chedraui-cms-components-2-x-listElement">Hechas con algod&oacute;n</li>
      <li class="chedrauimx-chedraui-cms-components-2-x-listElement">No se rompen f&aacute;cilmente</li>
      <li class="chedrauimx-chedraui-cms-components-2-x-listElement">Mayor suavidad y resistencia</li>
      </ul>',    'state_id'=>'1',    'imagen'=>'productos/9qZNvTtG9yAHwuSOfWqkCHoMV9YCugX99v0hqggH.webp',    'stock'=>'4',    'state_id'=>'1',    'inventory_type_id'=>'1'));
       DB::table('products')->insert(array('subcategorie_id'=>'1',    'brand_id'=>'1',
        'unit_id'=>'1',    'tax_id'=>'1',    'title'=>'Shampoo Mennen Zero% Cabello Saludable 700ml',    'slug'=>'shampoo-mennen-zero-cabello-saludable-700ml',    'sku'=>'3487776',    'price'=>'75',    'price_usd'=>'4',    'tags'=>'bebes',    'description'=>'',    'resumen'=>'Logra un cuidado de cabello ideal y saludable, usando el Shampoo con fórmula suave Mennen zero% en presentación de 700ml. Proporciona una limpieza delicada, puesto que está elaborado con una fórmula libre de alcohol, colorantes y siliconas. Toda tu familia puede disfrutar de los beneficios de Mennen, gracias a que cuenta con ingredientes que mantendrán un aspecto limpio, brillante y lleno de vitalidad.','description'=>'<p class="chedrauimx-chedraui-cms-components-2-x-descriptionAdditional">Disfruta de la suavidad que le da a tu cabello el Shampoo Mennen con f&oacute;rmula zero%, debido a que cuenta con los ingredientes necesarios para dejarlo limpio, suave y brillante despu&eacute;s de cada ducha.</p>
      <p><br /><span class="chedrauimx-chedraui-cms-components-2-x-titleDescription">Caracter&iacute;sticas Importantes</span></p>
      <ul class="chedrauimx-chedraui-cms-components-2-x-descriptionList">
      <li class="chedrauimx-chedraui-cms-components-2-x-listElement">Mantiene tu cabello saludable y con vida</li>
      <li class="chedrauimx-chedraui-cms-components-2-x-listElement">Shampoo suave ideal para toda tu familia</li>
      <li class="chedrauimx-chedraui-cms-components-2-x-listElement">Su f&oacute;rmula es sin alcohol, sin colorantes, sin siliconas</li>
      <li class="chedrauimx-chedraui-cms-components-2-x-listElement">Ingredientes necesarios para mantener un cabello limpio</li>
      </ul>',    'state_id'=>'1',    'imagen'=>'productos/XdWapCGsh21WY9kmhcI5QNlYNAOUTkAb0vAPhET5.webp',    'stock'=>'0',    'state_id'=>'1',    'inventory_type_id'=>'2'));

*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
