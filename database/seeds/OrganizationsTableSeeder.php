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
        DB::table('organizations')->insert( [ 'subdomain' => 'localhost', 'name' => 'Gradlead', 'modified_by' => 1,        'type' => 'gradlead' ]);
        DB::table('organizations')->insert( [ 'subdomain' => 'ashesi', 'name' => 'Ashesi University', 'modified_by' => 1,  'type' => 'school' ]);
        DB::table('organizations')->insert( [ 'subdomain' => 'vv', 'name' => 'Valley View University', 'modified_by' => 1, 'type' => 'school' ]);
        DB::table('organizations')->insert( [ 'subdomain' => 'overcore', 'name' => 'Overcore Tech', 'modified_by' => 1,   'type' => 'employer' ]);
        DB::table('organizations')->insert( [ 'subdomain' => 'hutchlabs', 'name' => 'Hutchlabs', 'modified_by' => 1,   'type' => 'employer' ]);

        DB::table('organizations_employers')->insert( [ 'organization_id' => 1, 'employer_id' => 4, 'modified_by' => 1 ]);
        DB::table('organizations_employers')->insert( [ 'organization_id' => 1, 'employer_id' => 5, 'modified_by' => 1 ]);
        DB::table('organizations_employers')->insert( [ 'organization_id' => 2, 'employer_id' => 4, 'modified_by' => 1 ]);
    }
}
