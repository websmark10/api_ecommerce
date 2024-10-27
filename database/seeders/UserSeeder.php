<?php


namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;



class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data=[
        ['name'=>'Juan Marcos', 'surname'=>'Vera Flores', 'email'=>'websmark@hotmail.com', 'type_user'=>'2', 'state'=>'1', 'role_id'=>1, 'password'=>'123123' ,'created_at'=> '2016-01-01 00:00:00' ] ,
        ['name'=>'Esperanza', 'surname'=>'Fuentes Pacheco', 'email'=>'esperanza_433@hotmail.com', 'type_user'=>'1', 'state'=>'1',  'role_id'=>null,'password'=>'123123' ,'created_at'=> '2016-01-01 00:00:00' ]
        ];

          DB::table('users')->insert($data);
    }
}
