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
        DB::table('documents')->insert(['name' => 'الأحدات المغربية', 'source' => 'AHDAT', 'sourceName' => 'al ahdat al maghribia', 'location' => 'National', 'type' => 'Journal', 'version' => 'Papier', 'frequence' => 'Quotidien', 'lang' => 'Arabe', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);

        DB::table('documents')->insert(['name' => 'Telquel', 'source' => 'Telquel', 'sourceName' => 'Telquel', 'location' => 'National', 'type' => 'Magasine', 'version' => 'Papier', 'frequence' => 'Hebdomadaire', 'lang' => 'Français', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);

        DB::table('documents')->insert(['name' => 'Le Matin', 'source' => 'Le Matin', 'sourceName' => 'Le Matin', 'location' => 'National', 'type' => 'Journal', 'version' => 'electronique', 'frequence' => 'Quotidien', 'lang' => 'Français', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
    }
}
