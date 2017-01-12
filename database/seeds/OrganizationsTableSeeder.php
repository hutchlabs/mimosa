<?php

use Illuminate\Database\Seeder;

class OrganizationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('organizations')->insert( [ 'subdomain' => 'localhost', 'name' => 'Gradlead', 'modified_by' => 1 ]);
        DB::table('organizations')->insert( [ 'subdomain' => 'ashesi', 'name' => 'Ashesi University', 'modified_by' => 1 ]);
        DB::table('organizations')->insert( [ 'subdomain' => 'vv', 'name' => 'Valley View University', 'modified_by' => 1 ]);
    }
}
