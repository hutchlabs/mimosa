<?php

use Illuminate\Database\Seeder;

class ThemesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('themes')->insert([
            'organization_id' => 1, 
            
            'home_header'=>'Kick-start your career on Gradlead, the preferred career network for students and graduates. Jobs, internships, and graduate programmes, it’s all there.',
            'home_first_title'=> 'Title 1',
            'home_second_title'=> 'Title 2',
            'home_third_title'=> 'Title 3',
            'home_first'=>'Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi  tempora incidunt ut labor.',
            'home_second'=>'Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi  tempora incidunt ut labor.',
            'home_third'=>'Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi  tempora incidunt ut labor.',
            
            'schools_header'=>'Give your students the best opportunities with Gradlead, the preferred career network for students and graduates.  Jobs, internships, and graduate programmes, it’s all there.',
            'schools_first_title'=> 'Title 1',
            'schools_second_title'=> 'Title 2',
            'schools_third_title'=> 'Title 3',
            'schools_first'=>'Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi  tempora incidunt ut labor.',
            'schools_second'=>'Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi  tempora incidunt ut labor.',
            'schools_third'=>'Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi  tempora incidunt ut labor.',

            'contact_header'=>'Contact us',
            'contact_first_title'=> 'Phone Us',
            'contact_second_title'=> 'Email Us',
            'contact_third_title'=> 'Visit Us',
            'contact_first'=>'#1: xxx-xxxx-xxxx<br/> 2: xxx-xxxx-xxxx<br/> #3: xxx-xxxx-xxxx',
            'contact_second'=>'For Employers: employers@gradlead.com<br/> For Schools: schools@gradlead.com<br/> For Support: support@gradlead.com',
            'contact_third'=>'123 Main St,<br/> Accra Central,<br> Accra, Ghana [<a href="">Google map</a>]'
        ]);
    }
}
