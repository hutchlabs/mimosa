<?php

use Illuminate\Database\Seeder;

class SystemDegreesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('system_degrees')->insert(['name'=>"Bachelor Degree", 'modified_by'=>1]);
        DB::table('system_degrees')->insert(['name'=>"Doctoral degree", 'modified_by'=>1]);
        DB::table('system_degrees')->insert(['name'=>"Masters degree", 'modified_by'=>1]);  
        DB::table('system_degrees')->insert(['name'=>"Course", 'modified_by'=>1]);
        DB::table('system_degrees')->insert(['name'=>"Other", 'modified_by'=>1]);
    }
}
