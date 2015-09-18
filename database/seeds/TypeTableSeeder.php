<?php

use Illuminate\Database\Seeder;

class TypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('type_category')->delete();

        DB::table('type_category')->insert([
            'id' => 1,
            't_name' => 'Βιβλία'
        ]);
    }
}
