<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
class rolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rol')->insert([
            'rol_name'=> 'estudiante',
        ]);
        DB::table('rol')->insert([
            'rol_name'=> 'maestr@',
        ]);
    }
}
