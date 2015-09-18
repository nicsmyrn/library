<?php

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        DB::table('category')->delete();

        $json = json_decode(file_get_contents(database_path().'/seeds/category.json'));

        $global = array();
        foreach($json as $c){
            $global[]  = array(
                'cat_id' => $c->cat_id,
                'name' => $c->name,
                'parent_id' => $c->parent_id,
                'level' => $c->level,
                'dewey' => $c->dewey,
                'type' => $c->type
            );
        }

        DB::table('category')->insert($global);

    }
}
