<?php

use Illuminate\Database\Seeder;

class PermissionUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permission_users')->insert(['user_id' => 2, 'permission_id' => 4]);
        DB::table('permission_users')->insert(['user_id' => 3, 'permission_id' => 4]);
        DB::table('permission_users')->insert(['user_id' => 4, 'permission_id' => 1]);
        DB::table('permission_users')->insert(['user_id' => 5, 'permission_id' => 2]);
        DB::table('permission_users')->insert(['user_id' => 6, 'permission_id' => 3]);
        DB::table('permission_users')->insert(['user_id' => 7, 'permission_id' => 5]);
    }
}
