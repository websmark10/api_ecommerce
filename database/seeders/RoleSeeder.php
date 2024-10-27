<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       // \App\Models\Role::factory(10)->create();


        $data=[
          'name'=>'ADMINISTRADOR GENERAL'
        ];

        DB::table('roles')->insert($data);
    }
}
