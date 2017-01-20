<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('system_roles')->insert( [ 'name' => 'Super Administrator', 'description' => 'Uber user: contrls everything.', ]);
        DB::table('system_roles')->insert( [ 'name' => 'Administrator', 'description' => 'Admin user. Has access to everything for a partiular organization.', ]);
        DB::table('system_roles')->insert( [ 'name' => 'Content Manager', 'description' => 'User can create, modify and remove content (posts, resumes, events etc) for organization.']);
        DB::table('system_roles')->insert( [ 'name' => 'Member', 'description' => 'User is an ordinary member of the organization and can only change settings related to them.' ]);
    }
}
