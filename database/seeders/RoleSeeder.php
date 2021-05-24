<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('roles')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $genders = [
            'Admin',
            'Teacher',
            'Student'
        ];
    	foreach ($genders as $key => $value) {
        	\App\Models\Role::insert(['name' => $value]);
    	}
    }
}
