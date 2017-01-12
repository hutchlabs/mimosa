<?php

use Illuminate\Database\Seeder;

class TestTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ztest')->insert( [ 'organization_id' => 1 ]);
        DB::table('ztest')->insert( [ 'organization_id' => 2 ]);
        DB::table('ztest')->insert( [ 'organization_id' => 3 ]);
    }
}
