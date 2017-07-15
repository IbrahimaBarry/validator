<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DocumentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('documents')->insert(['name' => 'الأحدات المغربية', 'source' => 'AHDAT', 'sourceName' => 'al ahdat al maghribia', 'type' => 'journal', 'version' => 'papier', 'frequence' => 'quotidien', 'lang' => 'arabe', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);

        DB::table('documents')->insert(['name' => 'Telquel', 'source' => 'Telquel', 'sourceName' => 'Telquel', 'type' => 'magasine', 'version' => 'papier', 'frequence' => 'hebdomadaire', 'lang' => 'français', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);

        DB::table('documents')->insert(['name' => 'Le Matin', 'source' => 'Le Matin', 'sourceName' => 'Le Matin', 'type' => 'journal', 'version' => 'electronique', 'frequence' => 'quotidien', 'lang' => 'français', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
    }
}
