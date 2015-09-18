<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('permissions')->delete();
        DB::table('permissions')->insert([
            ['name' => 'Δημιουργία Βιβλίου', 'slug' => 'create_book', 'description' => ''],
            ['name' => 'Επεξεργασία Βιβλίου', 'slug' => 'edit_book', 'description' => ''],
        ]);
    }
}
