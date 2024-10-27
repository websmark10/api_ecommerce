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
        Schema::create('supercategories', function (Blueprint $table) {
            $table->id();
            $table->string('code')->default('');
            $table->string('name');
            $table->string('imagen')->nullable();
            $table->text('icon')->nullable();
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
        DB::table('supercategories')->insert(array('code'=>'NA','name'=>'No Clasificado','companie_id'=>1,'icon'=>'<svg fill="#000000"  width="16" height="17" viewBox="0 0 1920 1920" xmlns="http://www.w3.org/2000/svg">
    <path d="M960 1807.059c-467.125 0-847.059-379.934-847.059-847.059 0-467.125 379.934-847.059 847.059-847.059 467.125 0 847.059 379.934 847.059 847.059 0 467.125-379.934 847.059-847.059 847.059M960 0C430.645 0 0 430.645 0 960s430.645 960 960 960 960-430.645 960-960S1489.355 0 960 0" fill-rule="evenodd"/>
</svg>'));
        DB::table('supercategories')->insert(array('code'=>'SUPER','name'=>'Supermercado','companie_id'=>1,'icon'=>'<svg  width="16" height="17" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M7.2998 5H22L20 12H8.37675M21 16H9L7 3H4M4 8H2M5 11H2M6 14H2M10 20C10 20.5523 9.55228 21 9 21C8.44772 21 8 20.5523 8 20C8 19.4477 8.44772 19 9 19C9.55228 19 10 19.4477 10 20ZM21 20C21 20.5523 20.5523 21 20 21C19.4477 21 19 20.5523 19 20C19 19.4477 19.4477 19 20 19C20.5523 19 21 19.4477 21 20Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
</svg>'));
        DB::table('supercategories')->insert(array('code'=>'VINOS','name'=>'Vinos y Licores','companie_id'=>1,'icon'=>'<svg fill="#000000"  width="16" height="17" viewBox="0 0 50 50" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path d="M22 0C21.476563 0 20.941406 0.183594 20.5625 0.5625C20.183594 0.941406 20 1.476563 20 2L20 5.6875C19.941406 5.882813 19.941406 6.085938 20 6.28125L20 13.34375C19.257813 13.652344 18.3125 14.144531 17.34375 15.125C16.082031 16.398438 15 18.421875 15 21.3125L15 47.09375C15 48.628906 16.277344 49.90625 17.8125 49.90625L32.1875 49.90625C33.722656 49.90625 35 48.628906 35 47.09375L35 21.3125C35 18.46875 33.914063 16.441406 32.65625 15.15625C31.695313 14.171875 30.75 13.695313 30 13.375L30 6.1875C30.027344 6.054688 30.027344 5.914063 30 5.78125L30 2C30 1.476563 29.816406 0.941406 29.4375 0.5625C29.058594 0.183594 28.523438 0 28 0 Z M 22 2L28 2L28 5L22 5 Z M 22 7L28 7L28 14C28.003906 14.425781 28.28125 14.804688 28.6875 14.9375C29.183594 15.101563 30.304688 15.597656 31.25 16.5625C32.195313 17.527344 33 18.957031 33 21.3125L33 47.09375C33 47.558594 32.652344 47.90625 32.1875 47.90625L17.8125 47.90625C17.347656 47.90625 17 47.558594 17 47.09375L17 21.3125C17 18.902344 17.8125 17.449219 18.75 16.5C19.6875 15.550781 20.792969 15.109375 21.3125 14.9375C21.71875 14.804688 21.996094 14.425781 22 14 Z M 19.8125 25C19.335938 25.089844 18.992188 25.511719 19 26L19 42C19 42.550781 19.449219 43 20 43L30 43C30.550781 43 31 42.550781 31 42L31 26C31 25.449219 30.550781 25 30 25L20 25C19.96875 25 19.9375 25 19.90625 25C19.875 25 19.84375 25 19.8125 25 Z M 21 27L29 27L29 30L21 30 Z M 21 32L29 32L29 41L21 41Z"/></svg>'));
        DB::table('supercategories')->insert(array('code'=>'BEBES','name'=>'Bebés','companie_id'=>1,'icon'=>'<svg height="17" width="16" version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
	 viewBox="0 0 512 512"  xml:space="preserve">
<style type="text/css">
	.st0{fill:#000000;}
</style>
<g>
	<path class="st0" d="M305.406,269.895c6.441,4.993,14.604,7.975,23.367,7.975c8.706,0,16.826-2.938,23.252-7.867
		c6.426-4.928,11.246-11.846,13.54-19.872c1.498-5.268-1.556-10.762-6.824-12.259c-5.268-1.505-10.746,1.549-12.245,6.817h-0.007
		c-1.086,3.828-3.416,7.179-6.528,9.56c-3.126,2.38-6.94,3.777-11.188,3.777c-4.269,0-8.105-1.418-11.239-3.828
		c-3.119-2.41-5.449-5.811-6.513-9.675c-1.462-5.283-6.918-8.38-12.201-6.933c-5.276,1.462-8.38,6.926-6.926,12.202
		C294.138,257.903,298.958,264.909,305.406,269.895z"/>
	<path class="st0" d="M220.091,250.131c1.506-5.262-1.541-10.754-6.809-12.259c-5.269-1.505-10.754,1.542-12.259,6.81
		c-1.1,3.836-3.423,7.186-6.535,9.568c-3.126,2.38-6.94,3.777-11.188,3.777c-4.262,0-8.112-1.418-11.239-3.828
		c-3.126-2.41-5.45-5.811-6.513-9.675c-1.462-5.283-6.918-8.38-12.201-6.933c-5.283,1.462-8.38,6.926-6.926,12.202
		c2.244,8.112,7.056,15.117,13.512,20.104c6.44,4.993,14.61,7.975,23.367,7.975c8.713,0,16.826-2.938,23.244-7.867
		C212.978,265.075,217.804,258.157,220.091,250.131z"/>
	<path class="st0" d="M494.002,217.703c-10.052-10.066-23.715-16.666-38.818-17.773c-9.436-44.376-33.188-83.454-66.173-112.156
		c-36.046-31.35-83.229-50.368-134.747-50.368c-51.44,0-98.565,18.96-134.582,50.216c-33.18,28.794-57.04,68.076-66.423,112.676
		c-13.692,1.788-26.012,8.134-35.282,17.404C6.897,228.783,0,244.226,0,261.145c0,16.891,6.897,32.334,17.976,43.413
		c11.079,11.08,26.522,17.969,43.435,17.969c1.166,0,2.302-0.029,3.438-0.086c14.792,35.142,39.042,65.319,69.603,87.311
		c14.046,10.117,29.468,18.504,45.902,24.851c-1.983-6.94-3.004-14.227-3.004-21.652c0-3.423,0.225-6.853,0.674-10.197
		c-9.509-4.537-18.548-9.914-27.029-16.008c-29.077-20.921-51.577-50.476-63.734-84.851l-4.393-12.411l-12.693,3.488
		c-2.924,0.789-5.811,1.216-8.764,1.216c-9.176,0-17.364-3.684-23.375-9.69c-6.006-6.014-9.694-14.198-9.694-23.353
		c0-9.183,3.687-17.375,9.694-23.382c6.01-6.006,14.199-9.69,23.375-9.69c0.572,0,1.418,0.058,2.613,0.138l13.178,1.02l1.954-13.026
		c6.404-42.574,27.999-80.176,59.088-107.155c7.772-6.738,16.131-12.809,24.988-18.136c0.767,4.806,1.947,9.307,3.596,13.439
		c2.613,6.564,6.274,12.252,10.616,17.108c7.606,8.518,17.122,14.517,27.066,19.431c14.922,7.33,31.045,12.411,44.593,18.743
		c6.773,3.141,12.874,6.556,17.875,10.493c5.008,3.959,8.915,8.344,11.702,13.685c1.498,2.887,4.486,4.653,7.743,4.58
		c3.257-0.079,6.159-1.982,7.519-4.943c14.698-31.841,20.003-56.895,20.003-76.572c0.022-13.431-2.519-24.294-6.072-32.847
		c23.288,7.396,44.499,19.452,62.548,35.128c31.118,27.072,52.654,64.761,59.001,107.436l2.106,14.054l14.053-2.15
		c1.867-0.289,3.51-0.427,5.015-0.427c9.176,0,17.339,3.684,23.375,9.69c6.014,6.007,9.661,14.199,9.697,23.382
		c-0.036,9.155-3.684,17.34-9.697,23.353c-6.036,6.006-14.198,9.69-23.375,9.69c-3.807,0-7.432-0.688-10.949-1.896l-13.432-4.74
		l-4.675,13.431c-12.013,34.606-34.49,64.393-63.618,85.474c-7.62,5.522-15.696,10.457-24.171,14.712
		c0.594,3.879,0.876,7.794,0.876,11.782c0,6.89-0.876,13.634-2.576,20.125c15.168-6.23,29.418-14.198,42.48-23.664
		c30.409-22.021,54.551-52.148,69.263-87.282c2.208,0.253,4.501,0.398,6.803,0.398c16.912,0,32.334-6.889,43.406-17.969
		C505.089,293.479,512,278.036,512,261.145C512,244.226,505.089,228.783,494.002,217.703z M221.64,130.008
		c-12.324-5.195-23.143-10.999-30.474-18.736c-3.69-3.879-6.586-8.214-8.648-13.46c-1.701-4.364-2.786-9.459-3.119-15.465
		c11.123-5.204,22.875-9.307,35.128-12.115c0.058,9.626,2.294,24.692,11.868,42.798c4.277,8.12,10.023,16.818,17.636,25.936
		C236.425,135.899,228.804,133.041,221.64,130.008z M286.677,156.64c-23.918-19.235-37.53-36.936-45.244-51.548
		c-8.387-15.906-9.893-28.201-9.907-35.322c0-0.956,0.029-1.795,0.073-2.554c7.424-0.948,14.979-1.469,22.666-1.469
		c10.413,0,20.602,0.933,30.503,2.648c1.027,1.186,2.098,2.547,3.154,4.146c4.48,6.789,8.988,17.448,9.024,34.338
		C296.953,119.638,294.268,136.023,286.677,156.64z"/>
	<path class="st0" d="M256,351.33c-16.962-0.007-32.471,6.926-43.579,18.056c-11.13,11.101-18.056,26.61-18.049,43.579
		c-0.008,16.971,6.918,32.479,18.049,43.58c11.108,11.13,26.617,18.056,43.579,18.048c16.977,0.007,32.478-6.918,43.588-18.048
		c11.13-11.101,18.055-26.609,18.048-43.58c0.007-16.97-6.918-32.478-18.048-43.579C288.478,358.255,272.977,351.323,256,351.33z
		 M284.672,425.072c-2.344,5.558-6.318,10.342-11.282,13.699c-4.986,3.358-10.891,5.298-17.39,5.305
		c-4.334-0.008-8.387-0.876-12.1-2.446c-5.565-2.345-10.341-6.311-13.699-11.282c-3.358-4.986-5.298-10.891-5.304-17.383
		c0-4.342,0.868-8.394,2.438-12.107c2.352-5.558,6.31-10.342,11.282-13.699c4.986-3.358,10.892-5.297,17.382-5.304
		c4.342,0.008,8.395,0.875,12.107,2.439c5.565,2.352,10.349,6.318,13.706,11.289c3.358,4.979,5.29,10.891,5.298,17.382
		C287.111,417.3,286.243,421.353,284.672,425.072z"/>
	<path class="st0" d="M256.008,314.365c-41.857,0-75.812,20.291-75.812,45.338c0,7.483,3.04,14.546,8.417,20.777
		c3.256-5.384,7.23-10.428,11.788-14.994c14.821-14.842,34.577-23.034,55.578-23.034c21.081,0,40.808,8.192,55.651,23.071
		c4.566,4.53,8.502,9.574,11.767,14.958c5.376-6.231,8.416-13.294,8.416-20.777C331.812,334.656,297.887,314.365,256.008,314.365z"
		/>
</g>
</svg>'));
        DB::table('supercategories')->insert(array('code'=>'FARMACIA','name'=>'Farmacia','companie_id'=>1,'icon'=>'<svg fill="#000000" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
	  width="16" height="17" viewBox="0 0 256 253" enable-background="new 0 0 256 253" xml:space="preserve">
<path d="M128,114c-27.89,0-50.5,22.61-50.5,50.5S100.11,215,128,215s50.5-22.61,50.5-50.5S155.89,114,128,114z M157.41,173.23
	h-20.68v20.68h-17.46v-20.68H98.59v-17.46h20.68v-20.68h17.46v20.68h20.68V173.23z M2.112,69c0,13.678,9.625,25.302,22,29.576V233
	h-22v18h252v-18h-22V98.554c12.89-3.945,21.699-15.396,22-29.554v-8h-252V69z M65.402,68.346c0,6.477,6.755,31.47,31.727,31.47
	c21.689,0,31.202-19.615,31.202-31.47c0,11.052,7.41,31.447,31.464,31.447c21.733,0,31.363-20.999,31.363-31.447
	c0,14.425,9.726,26.416,22.954,30.154V233h-172V98.594C55.514,94.966,65.402,82.895,65.402,68.346z M254.112,54h-252l32-32V2h189v20
	h-0.168L254.112,54z"/>
</svg>'));
        DB::table('supercategories')->insert(array('code'=>'MODABELLEZA','name'=>'Moda y Belleza','companie_id'=>1,'icon'=>'<svg width="16" height="17" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M11 10.5C11 7.46243 13.4624 5 16.5 5C19.5376 5 22 7.46243 22 10.5C22 13.5376 19.5376 16 16.5 16C13.4624 16 11 13.5376 11 10.5Z" stroke="#1C274C" stroke-width="1.5"/>
<path d="M16.5 20V16M16.5 20H19.5M16.5 20H13.5" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M2 11V10.25C1.58579 10.25 1.25 10.5858 1.25 11H2ZM8 11H8.75C8.75 10.5858 8.41421 10.25 8 10.25V11ZM2 11.75H8V10.25H2V11.75ZM7.25 11V17H8.75V11H7.25ZM2.75 17V11H1.25V17H2.75ZM5 19.25C3.75736 19.25 2.75 18.2426 2.75 17H1.25C1.25 19.0711 2.92893 20.75 5 20.75V19.25ZM7.25 17C7.25 18.2426 6.24264 19.25 5 19.25V20.75C7.07107 20.75 8.75 19.0711 8.75 17H7.25Z" fill="#1C274C"/>
<path d="M3 11H7V5.61799C7 4.87461 6.21769 4.39111 5.55279 4.72356L3.55279 5.72356C3.214 5.89295 3 6.23922 3 6.61799V11Z" stroke="#1C274C" stroke-width="1.5"/>
</svg>'));
        DB::table('supercategories')->insert(array('code'=>'HOGAR','name'=>'Hogar, oficina y jardín','companie_id'=>1,'icon'=>'<svg  width="16" height="17" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M22 22L2 22" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"/>
<path d="M2 11L6.06296 7.74968M22 11L13.8741 4.49931C12.7784 3.62279 11.2216 3.62279 10.1259 4.49931L9.34398 5.12486" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"/>
<path d="M15.5 5.5V3.5C15.5 3.22386 15.7239 3 16 3H18.5C18.7761 3 19 3.22386 19 3.5V8.5" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"/>
<path d="M4 22V9.5" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"/>
<path d="M20 9.5V13.5M20 22V17.5" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"/>
<path d="M15 22V17C15 15.5858 15 14.8787 14.5607 14.4393C14.1213 14 13.4142 14 12 14C10.5858 14 9.87868 14 9.43934 14.4393M9 22V17" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M14 9.5C14 10.6046 13.1046 11.5 12 11.5C10.8954 11.5 10 10.6046 10 9.5C10 8.39543 10.8954 7.5 12 7.5C13.1046 7.5 14 8.39543 14 9.5Z" stroke="#1C274C" stroke-width="1.5"/>
</svg>'));
        DB::table('supercategories')->insert(array('code'=>'TECNOLOGIA','name'=>'Tecnologia','companie_id'=>1,'icon'=>'<svg  width="16" height="17" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M22 22L2 22" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"/>
<path d="M2 11L6.06296 7.74968M22 11L13.8741 4.49931C12.7784 3.62279 11.2216 3.62279 10.1259 4.49931L9.34398 5.12486" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"/>
<path d="M15.5 5.5V3.5C15.5 3.22386 15.7239 3 16 3H18.5C18.7761 3 19 3.22386 19 3.5V8.5" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"/>
<path d="M4 22V9.5" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"/>
<path d="M20 9.5V13.5M20 22V17.5" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"/>
<path d="M15 22V17C15 15.5858 15 14.8787 14.5607 14.4393C14.1213 14 13.4142 14 12 14C10.5858 14 9.87868 14 9.43934 14.4393M9 22V17" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M14 9.5C14 10.6046 13.1046 11.5 12 11.5C10.8954 11.5 10 10.6046 10 9.5C10 8.39543 10.8954 7.5 12 7.5C13.1046 7.5 14 8.39543 14 9.5Z" stroke="#1C274C" stroke-width="1.5"/>
</svg>'));
        DB::table('supercategories')->insert(array('code'=>'DEPORTES','name'=>'Deportes y Ocio','companie_id'=>1,'icon'=>'<svg fill="#000000"  width="16" height="17" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">

<g id="Sport">

<path d="M256,46.5544c-115.98,0-210,94.0209-210,210,11.0614,278.5613,408.9813,278.4822,420-.0011C466,140.5753,371.98,46.5544,256,46.5544Zm13.1314,64.0816,43.3441-28.8626a184.32,184.32,0,0,1,92.236,67.287L390.73,198.9456,322.2637,220.89l-53.1323-39.0514ZM199.5266,81.7734l43.3548,28.8679v71.192L189.7405,220.89l-68.47-21.9487-13.98-49.8832A184.2945,184.2945,0,0,1,199.5266,81.7734Zm-91.7,282.996a182.38,182.38,0,0,1-35.564-108.4681l40.9409-32.3831L181.6186,245.85,202.03,309.3984,159.6816,366.89Zm205.2255,66.3535c-35.6088,12.1391-78.5,12.137-114.1089-.0011l-18.0682-48.7359,42.4084-57.5736h65.437l42.4,57.5757Zm91.1188-66.3524-51.8549,2.1213L309.974,309.3994l20.4138-63.5507,68.4107-21.9263,40.9387,32.381A182.3643,182.3643,0,0,1,404.1711,364.7705Z"/>

</g>

</svg>'));
        DB::table('supercategories')->insert(array('code'=>'JUGUETERIA','name'=>'Jugueteria','companie_id'=>1,'icon'=>'<svg
   xmlns:dc="http://purl.org/dc/elements/1.1/"
   xmlns:cc="http://creativecommons.org/ns#"
   xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
   xmlns:svg="http://www.w3.org/2000/svg"
   xmlns="http://www.w3.org/2000/svg"
   version="1.1"
   width="16"
   height="17"
   viewBox="0 0 14 14"
   id="svg2">
  <metadata
     id="metadata8">
    <rdf:RDF>
      <cc:Work
         rdf:about="">
        <dc:format>image/svg+xml</dc:format>
        <dc:type
           rdf:resource="http://purl.org/dc/dcmitype/StillImage" />
        <dc:title></dc:title>
      </cc:Work>
    </rdf:RDF>
  </metadata>
  <defs
     id="defs6" />
  <rect
     width="14"
     height="14"
     x="0"
     y="0"
     id="canvas"
     style="fill:none;stroke:none;visibility:hidden" />
  <path
     d="M 2,1.25 C 2.647974,2 2.2974384,2.5190678 2,3 1.7531321,3.399164 1,4.7359503 1,5 1.1245269,5.4647409 1.5570886,5.78125 2,5.78125 2.3792669,5.5622802 2.680369,5.069631 3,4.75 3,4.75 4,6 4,7 4,7.6083221 3,9.875 3,9.875 c 0.1144967,0.1144967 0.7421469,0.430908 1,0.5 0,0 1.0213054,-2.1127596 2,-2.375 0.6239458,-0.1671858 1.4137017,-0.1570981 2,0 0.983714,0.2635854 2,2.375 2,2.375 0.253438,-0.06791 0.826381,-0.399761 1,-0.5 0,0 -0.868693,-1.8849568 -1,-2.375 0,0 -0.4204688,-1.2717267 0,-2 1.290341,-0.7449788 2.5,-0.097874 2.5,2 0.528174,-0.3049415 1.015684,-1.5 1,-2 C 13.024093,3.7238916 11,3 9.5,4.5 8.5345142,3.9425765 6.8650717,3.8842301 5.5,4.25 5.5,2 3.4597458,1.25 2,1.25 z M 2.625,3 C 2.8321068,3 3,3.1678932 3,3.375 3,3.5821068 2.8321068,3.75 2.625,3.75 2.4178932,3.75 2.25,3.5821068 2.25,3.375 2.25,3.1678932 2.4178932,3 2.625,3 z M 1.75,10 1,11 c 0,0 2,2.25 6,2.25 4,0 6,-2.25 6,-2.25 L 12.25,10 C 12.25,10 10,12 7,12 4,12 1.75,10 1.75,10 z"
     id="toys"
     style="fill:#000000;fill-opacity:1;stroke:none" />
</svg>'));

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('supercategories');
    }
};