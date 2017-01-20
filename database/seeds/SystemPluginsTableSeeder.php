<?php

use Illuminate\Database\Seeder;

class SystemPluginsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('system_permissions')->insert([
            'organization_id' => 1,
            'preselect' => 1,
            'screening' => 1,
            'tracking' => 1,
            'badges' => 1,
            'events' => 1,
            'modified_by'=>1]);
        
        DB::table('system_permissions')->insert([
            'organization_id' => 2,
            'preselect' => 1,
            'screening' => 0,
            'tracking' => 1,
            'badges' => 0,
            'events' => 1,
            'modified_by'=>1]);
        
        DB::table('system_permissions')->insert([
            'organization_id' => 3,
            'preselect' => 0,
            'screening' => 0,
            'tracking' => 0,
            'badges' => 0,
            'events' => 0,
            'modified_by'=>1]);
    }
}
