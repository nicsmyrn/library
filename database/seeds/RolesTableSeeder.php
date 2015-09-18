<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->delete();

        DB::table('roles')->insert([
            'name' => 'Υπεύθυνος Βιβλιοθήκης',
            'slug' => 'librarian',
            'description' => ''
        ]);
    }
}
