<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(OrganizationsTableSeeder::class);
        $this->call(TestTableSeeder::class);
        $this->call(ThemesTableSeeder::class);

        $this->call(SystemDegreesTableSeeder::class);
        $this->call(SystemIndustriesTableSeeder::class);
        $this->call(SystemJobTypesTableSeeder::class);
        $this->call(SystemLanguagesTableSeeder::class);
        $this->call(SystemMajorsTableSeeder::class);
        $this->call(SystemPluginsTableSeeder::class);
        $this->call(SystemSkillsTableSeeder::class);
        $this->call(SystemUniversityTableSeeder::class);
        $this->call(CountriesTableSeeder::class);
    }
}
