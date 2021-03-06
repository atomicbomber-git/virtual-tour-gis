<?php

use Illuminate\Database\Seeder;
use App\Location;
use App\Layer;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $layers = Layer::select('layer_id')
            ->get();

        factory(\App\Location::class, 2)
            ->make()
            ->each(function ($location) use($layers) {
                $location->layer_id = $layers->random()->layer_id;
                $location->save();
            });
    }
}
