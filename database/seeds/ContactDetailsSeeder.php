<?php

use App\ContactDetails;
use Illuminate\Database\Seeder;

class ContactDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $details = [
            'id' => 1,
            'email' => 'info@hiddentreasures.com',
            'phone' => '08099993333',
            'address' => 'London, United Kingdom',
            'ig_link' => '#',
            'fb_link' => '#',
            'tw_link' => '#',
            'li_link' => '#',
        ];

        ContactDetails::create($details);
    }
}