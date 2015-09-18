<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->delete();
        DB::table('users')->insert([
            ['first_name'=>'Χρυσάνθη', 'last_name'=>'Αγίου', 'username'=>'chagiou', 'email'=>'chagiou@gmail.com', 'password'=>bcrypt('1453'), 'role_id' => 1, 'org_id'=>1],
            ['first_name'=>'Μιχάλης', 'last_name'=>'Βαρέκασ', 'username'=>'varekas','email'=>'varekas@gmail.com', 'password'=>bcrypt('1453'), 'role_id' => 1, 'org_id'=>2]
        ]);
    }
}
