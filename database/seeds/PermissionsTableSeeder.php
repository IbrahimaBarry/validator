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
        DB::table('permissions')->insert(['name' => 'reception']);
        DB::table('permissions')->insert(['name' => 'scan']);
        DB::table('permissions')->insert(['name' => 'import']);
        DB::table('permissions')->insert(['name' => 'clipping']);
        DB::table('permissions')->insert(['name' => 'export']);
    }
}
