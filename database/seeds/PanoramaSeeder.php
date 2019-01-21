<?php

use Illuminate\Database\Seeder;
use App\Location;
use App\Panorama;

class PanoramaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $locations = Location::select('id', 'latitude', 'longitude')
            ->withCount('panoramas')
            ->get();

        factory(Panorama::class, 10)
            ->make()
            ->each(function ($panorama) use($locations) {
                $location = $locations->random();
                $panorama->location_id = $location->id;
                $panorama->latitude = $location->latitude + ($location->panoramas_count / 100000);
                $panorama->longitude = $location->longitude;
                $location->panoramas_count++;
                $panorama->save();
                $panorama
                    ->addMedia(__DIR__ . '/images/panorama_2.jpg')
                    ->preservingOriginal()
                    ->toMediaCollection(config('media.collections.panoramas'));
            });
    }
}
