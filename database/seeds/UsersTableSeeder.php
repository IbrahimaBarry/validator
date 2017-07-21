<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(['name' => 'BARRY Ibrahima', 'email' => 'ibarry@itelsys.ma',
        	'password' => bcrypt('ibarry'), 'role' => 'admin']);
        DB::table('users')->insert(['name' => 'Agent clipping1', 'email' => 'clipping1@itelsys.ma',
            'password' => bcrypt('ibarry'), 'role' => 'agent']);
        DB::table('users')->insert(['name' => 'Agent clipping2', 'email' => 'clipping2@itelsys.ma',
            'password' => bcrypt('ibarry'), 'role' => 'agent']);
        DB::table('users')->insert(['name' => 'Agent reception', 'email' => 'reception@itelsys.ma',
            'password' => bcrypt('ibarry'), 'role' => 'agent']);
        DB::table('users')->insert(['name' => 'Agent scan', 'email' => 'scan@itelsys.ma',
            'password' => bcrypt('ibarry'), 'role' => 'agent']);
        DB::table('users')->insert(['name' => 'Agent import', 'email' => 'import@itelsys.ma',
            'password' => bcrypt('ibarry'), 'role' => 'agent']);
        DB::table('users')->insert(['name' => 'Agent export', 'email' => 'export@itelsys.ma',
            'password' => bcrypt('ibarry'), 'role' => 'agent']);
    }
}
