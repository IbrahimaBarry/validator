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
        DB::table('documents')->insert(['name' => 'رسالة الامة', 'source' => 'Rissala', 'sourceName' => 'Rissala Al Oma', 'location' => 'National', 'type' => 'Journal', 'version' => 'Papier', 'frequence' => 'Quotidien', 'lang' => 'Arabe', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);

        DB::table('documents')->insert(['name' => 'اخر ساعة', 'source' => 'Saa', 'sourceName' => 'Akhir saa', 'location' => 'National', 'type' => 'Journal', 'version' => 'Papier', 'frequence' => 'Quotidien', 'lang' => 'Arabe', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);

        DB::table('documents')->insert(['name' => 'الحركة', 'source' => 'Haraka', 'sourceName' => 'Al Haraka', 'location' => 'National', 'type' => 'Journal', 'version' => 'Papier', 'frequence' => 'Quotidien', 'lang' => 'Arabe', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        
        DB::table('documents')->insert(['name' => 'الصباح', 'source' => 'Sabah', 'sourceName' => 'Al Sabah', 'location' => 'National', 'type' => 'Journal', 'version' => 'Papier', 'frequence' => 'Quotidien', 'lang' => 'Arabe', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);

        DB::table('documents')->insert(['name' => 'العلم', 'source' => 'Al alam', 'sourceName' => 'Al alam', 'location' => 'National', 'type' => 'Journal', 'version' => 'Papier', 'frequence' => 'Quotidien', 'lang' => 'Arabe', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);

        DB::table('documents')->insert(['name' => 'النهار المغربية', 'source' => 'Nahar', 'sourceName' => 'AL Nahar Al maghribia', 'location' => 'National', 'type' => 'Journal', 'version' => 'Papier', 'frequence' => 'Quotidien', 'lang' => 'Arabe', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);

        DB::table('documents')->insert(['name' => 'بيان اليوم', 'source' => 'Bayan', 'sourceName' => 'Bayan Al yawm', 'location' => 'National', 'type' => 'Journal', 'version' => 'Papier', 'frequence' => 'Quotidien', 'lang' => 'Arabe', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);

        DB::table('documents')->insert(['name' => 'الاحداث المغربية', 'source' => 'Ahdat', 'sourceName' => 'Al ahdat al maghribia', 'location' => 'National', 'type' => 'Journal', 'version' => 'Papier', 'frequence' => 'Quotidien', 'lang' => 'Arabe', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);

        DB::table('documents')->insert(['name' => 'الاخبار', 'source' => 'Akhbar', 'sourceName' => 'Al akhbar', 'location' => 'National', 'type' => 'Journal', 'version' => 'Papier', 'frequence' => 'Quotidien', 'lang' => 'Arabe', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);

        DB::table('documents')->insert(['name' => 'الصحراء المغربية', 'source' => 'Sahraa', 'sourceName' => 'Al Sahraa AL Maghribia', 'location' => 'National', 'type' => 'Journal', 'version' => 'Papier', 'frequence' => 'Quotidien', 'lang' => 'Arabe', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);

        DB::table('documents')->insert(['name' => 'الاتحاد الاشتراكي', 'source' => 'Itihadi', 'sourceName' => 'Al Itihad Al Ichtiraki', 'location' => 'National', 'type' => 'Journal', 'version' => 'Papier', 'frequence' => 'Quotidien', 'lang' => 'Arabe', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);

        DB::table('documents')->insert(['name' => 'اخبار اليوم', 'source' => 'Akhbar L', 'sourceName' => 'Akhbar Lyaoum', 'location' => 'National', 'type' => 'Journal', 'version' => 'Papier', 'frequence' => 'Quotidien', 'lang' => 'Arabe', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);

        DB::table('documents')->insert(['name' => 'المساء', 'source' => 'Massaa', 'sourceName' => 'Al massaa', 'location' => 'National', 'type' => 'Journal', 'version' => 'Papier', 'frequence' => 'Quotidien', 'lang' => 'Arabe', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);

        DB::table('documents')->insert(['name' => 'L\'opinion', 'source' => 'Opinion', 'sourceName' => 'L\'Opinion', 'location' => 'National', 'type' => 'Journal', 'version' => 'Papier', 'frequence' => 'Quotidien', 'lang' => 'Français', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);

        DB::table('documents')->insert(['name' => 'Aujourd\'hui le maroc', 'source' => 'Aujourdh', 'sourceName' => 'Aujourd\'hui le maroc', 'location' => 'National', 'type' => 'Journal', 'version' => 'Papier', 'frequence' => 'Quotidien', 'lang' => 'Français', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);

        DB::table('documents')->insert(['name' => 'Les éco', 'source' => 'Eco', 'sourceName' => 'Les Echos', 'location' => 'National', 'type' => 'Journal', 'version' => 'Papier', 'frequence' => 'Quotidien', 'lang' => 'Français', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);

        DB::table('documents')->insert(['name' => 'L\'économiste', 'source' => 'Economis', 'sourceName' => 'L\'économiste', 'location' => 'National', 'type' => 'Journal', 'version' => 'Papier', 'frequence' => 'Quotidien', 'lang' => 'Français', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);

        DB::table('documents')->insert(['name' => 'Libération', 'source' => 'Liberat', 'sourceName' => 'Libération', 'location' => 'National', 'type' => 'Journal', 'version' => 'Papier', 'frequence' => 'Quotidien', 'lang' => 'Français', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);

        DB::table('documents')->insert(['name' => 'Al bayane', 'source' => 'Albayane', 'sourceName' => 'Al bayane', 'location' => 'National', 'type' => 'Journal', 'version' => 'Papier', 'frequence' => 'Quotidien', 'lang' => 'Français', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);

        DB::table('documents')->insert(['name' => 'Le matin', 'source' => 'Matin', 'sourceName' => 'Le Matin', 'location' => 'National', 'type' => 'Journal', 'version' => 'Papier', 'frequence' => 'Quotidien', 'lang' => 'Français', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);

        DB::table('documents')->insert(['name' => 'La nouvelle tribune', 'source' => 'tribune', 'sourceName' => 'La nouvelle tribune', 'location' => 'National', 'type' => 'Journal', 'version' => 'Papier', 'frequence' => 'Hebdomadaire', 'lang' => 'Français', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);

        DB::table('documents')->insert(['name' => 'La vie éco', 'source' => 'vie éco', 'sourceName' => 'La vie éco', 'location' => 'National', 'type' => 'Journal', 'version' => 'Papier', 'frequence' => 'Hebdomadaire', 'lang' => 'Français', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);

        DB::table('documents')->insert(['name' => 'La vérité', 'source' => 'vérité', 'sourceName' => 'La vérité', 'location' => 'National', 'type' => 'Journal', 'version' => 'Papier', 'frequence' => 'Hebdomadaire', 'lang' => 'Français', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);

        DB::table('documents')->insert(['name' => 'Finance News', 'source' => 'Finance', 'sourceName' => 'Finance News', 'location' => 'National', 'type' => 'Journal', 'version' => 'Papier', 'frequence' => 'Hebdomadaire', 'lang' => 'Français', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);

        DB::table('documents')->insert(['name' => 'Le canard libéré', 'source' => 'Canard', 'sourceName' => 'Le canard libéré', 'location' => 'National', 'type' => 'Journal', 'version' => 'Papier', 'frequence' => 'Hebdomadaire', 'lang' => 'Français', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);

        DB::table('documents')->insert(['name' => 'السبيل', 'source' => 'Alsabil', 'sourceName' => 'Alsabil', 'location' => 'National', 'type' => 'Journal', 'version' => 'Papier', 'frequence' => 'Hebdomadaire', 'lang' => 'Arabe', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);

        DB::table('documents')->insert(['name' => 'الوطن', 'source' => 'Alwatan', 'sourceName' => 'Alwatan', 'location' => 'National', 'type' => 'Journal', 'version' => 'Papier', 'frequence' => 'Hebdomadaire', 'lang' => 'Arabe', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);

        DB::table('documents')->insert(['name' => 'الأسبوع', 'source' => 'Alousbouea', 'sourceName' => 'Alousbouea', 'location' => 'National', 'type' => 'Journal', 'version' => 'Papier', 'frequence' => 'Hebdomadaire', 'lang' => 'Arabe', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);

        DB::table('documents')->insert(['name' => 'المنعطف', 'source' => 'Almounaataf', 'sourceName' => 'Almounaataf', 'location' => 'National', 'type' => 'Journal', 'version' => 'Papier', 'frequence' => 'Hebdomadaire', 'lang' => 'Arabe', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);

        DB::table('documents')->insert(['name' => 'المشعل ', 'source' => 'michaal', 'sourceName' => 'Almichaal', 'location' => 'National', 'type' => 'Journal', 'version' => 'Papier', 'frequence' => 'Hebdomadaire', 'lang' => 'Arabe', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);

        DB::table('documents')->insert(['name' => 'الايام الاسبوعية ', 'source' => 'Alayam', 'sourceName' => 'Alayam', 'location' => 'National', 'type' => 'Journal', 'version' => 'Papier', 'frequence' => 'Hebdomadaire', 'lang' => 'Arabe', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
    }
}
