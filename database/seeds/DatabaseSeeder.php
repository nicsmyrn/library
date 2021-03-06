<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

            $this->call(TypeTableSeeder::class);
            $this->call(CategoryTableSeeder::class);
            $this->call(OrganizationTableSeeder::class);
            $this->call(RolesTableSeeder::class);
            $this->call(UserTableSeeder::class);
            $this->call(PermissionsTableSeeder::class);

        Model::reguard();
    }
}
