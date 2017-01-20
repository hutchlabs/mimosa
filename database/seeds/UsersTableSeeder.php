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
        DB::table('users')->insert([
            'name' => 'Super Admin', 
            'email' => 'uber@gradlead.com',
            'organization_id' => '1',
            'role_id' => '1',
            'type' => 'gradlead',
            'password' => bcrypt('uber'),
        ]);

        DB::table('users')->insert([
            'name' => 'Admin', 
            'email' => 'admin@ashesi.edu',
            'role_id' => '2',
            'organization_id' => '2',
            'type' => 'school',
            'password' => bcrypt('admin'),
        ]);

        DB::table('users')->insert([
            'name' => 'Student', 
            'email' => 'student@ashesi.edu',
            'role_id' => '4',
            'organization_id' => '2',
            'type' => 'student',
            'password' => bcrypt('student'),
        ]);

        DB::table('users')->insert([
            'name' => 'Graduate', 
            'email' => 'graduate@ashesi.edu',
            'role_id' => '4',
            'organization_id' => '2',
            'type' => 'graduate',
            'password' => bcrypt('graduate'),
        ]);
    }
}
