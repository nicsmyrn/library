<?php

use Illuminate\Database\Seeder;

class OrganizationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('organizations')->delete();
        DB::table('organizations')->insert([
            ['name'=>'Γενικό Λύκειο Βουκολιών'],
            ['name'=>'Γενικό Λύκειο Κολυμβαρίου'],
        ]);
    }
}
