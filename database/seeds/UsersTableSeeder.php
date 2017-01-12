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
            'email' => 'uber@gmail.com',
            'role_id' => '1',
            'password' => bcrypt('uber'),
        ]);

        DB::table('users')->insert([
            'name' => 'Admin', 
            'email' => 'admin@gmail.com',
            'role_id' => '2',
            'password' => bcrypt('admin'),
        ]);
    }
}
