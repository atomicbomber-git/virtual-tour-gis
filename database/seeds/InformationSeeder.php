<?php

use Illuminate\Database\Seeder;
use App\Information;

class InformationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Information::create([
            "type" => Information::ABOUT,
            "title" => "About",
            "icon" => "fa-info",
            "content" => "",
        ]);

        Information::create([
            "type" => Information::CONTACTS,
            "title" => "Contacts",
            "icon" => "fa-list",
            "content" => "",
        ]);
    }
}
