<?php

use Illuminate\Database\Seeder;

class SystemJobTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('system_job_types')->insert(['name'=>"Freelance", 'modified_by'=>1]);
        DB::table('system_job_types')->insert(['name'=>"Internship", 'modified_by'=>1]);
        DB::table('system_job_types')->insert(['name'=>"Part time job", 'modified_by'=>1]);
        DB::table('system_job_types')->insert(['name'=>"Full time job", 'modified_by'=>1]);
        DB::table('system_job_types')->insert(['name'=>"Volunteer", 'modified_by'=>1]);
    }
}
