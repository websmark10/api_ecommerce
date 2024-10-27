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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('unique_id')->nullable();
            $table->string('name');
            $table->string('surname')->nullable;
            $table->string('email')->index();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->index();
            $table->foreignId('user_type_id')->default(1)->constrained('user_types')->comment(' 1 Sistema de Administración | 2 Sistema Ecommerce ');
            $table->foreignId('role_id')->default(1)->constrained('roles')->comment('1 ClientEcommerce| 2 Programmer | 3  Administrador | 4 Ventas | 5 Inventory |6 Reportes');
            $table->timestamp('birthday')->nullable();
            $table->foreignId('gender_id')->nullable()->constrained('genders');
            $table->string('avatar')->nullable();
            $table->string('phone')->nullable();
            $table->rememberToken()->nullable();
            $table->foreignId('companie_id')->constrained('companies');
            $table->foreignId('state_id')->default(1)->constrained('states');
           $table->unique(['email', 'companie_id','user_type_id']);

            $table->string('code_verified')->nullable();

            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();

            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users');
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->foreign('deleted_by')->references('id')->on('users');



        });
       DB::table('users')->insert(array(
       'name'=>'JM MIDESP ADMIN','surname'=>'Vera Flores',
       'email'=>'websmark@hotmail.com','companie_id'=>1, //MI DESPENSA
       'password'=>'$2y$10$odFrrX/9Jbml249i2T6i6u6b.JuZZvWcYL9z5hHX1rh6eRvWPwSd6',
       'user_type_id'=>1,  //Administrador
       'role_id'=>'2',
       'avatar'=>'man.jpg'));
  //***********PASSWORD************  123123 */
       DB::table('users')->insert(array(
        'name'=>'JM AURR ADMIN','surname'=>'Vera Flores',
        'email'=>'websmark@hotmail.com','companie_id'=>2, //AURRERA
        'password'=>'$2y$10$odFrrX/9Jbml249i2T6i6u6b.JuZZvWcYL9z5hHX1rh6eRvWPwSd6',
        'user_type_id'=>1,  //Administrador
        'role_id'=>'2',
        'avatar'=>'man.jpg'));

        DB::table('users')->insert(array(
            'name'=>'JM MIDESP ECOMMERCE','surname'=>'Vera Flores',
            'email'=>'websmark10@gmail.com','companie_id'=>1, //MI DESPENSA
            'password'=>'$2y$10$odFrrX/9Jbml249i2T6i6u6b.JuZZvWcYL9z5hHX1rh6eRvWPwSd6',
            'user_type_id'=>2,  //Web
            'role_id'=>'2',
            'avatar'=>'man.jpg'));

            DB::table('users')->insert(array(
             'name'=>'JM AURR ECOMMERCE','surname'=>'Vera Flores',
             'email'=>'websmark10@gmail.com','companie_id'=>2, //AURRERA
             'password'=>'$2y$10$odFrrX/9Jbml249i2T6i6u6b.JuZZvWcYL9z5hHX1rh6eRvWPwSd6',
             'user_type_id'=>2,  //Web
             'role_id'=>'2',
             'avatar'=>'man.jpg'));




    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
