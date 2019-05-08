<?php

use Illuminate\Database\Seeder;
use App\Location;
use App\Panorama;
use App\Link;

class PanoramaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function () {
            $locations = Location::select('id', 'latitude', 'longitude')
                ->get();

            foreach ($locations as $location) {

                $panoramas_count = 1;

                factory(Panorama::class, 6)
                    ->make()
                    ->each(function ($panorama) use ($location, &$panoramas_count) {
                        $panorama->location_id = $location->id;
                        $panorama->latitude = $location->latitude + ($panoramas_count / 1000);
                        $panorama->longitude = $location->longitude;

                        $panorama->save();
                        $panorama
                            ->addMedia(__DIR__ . '/images/panorama_2.jpg')
                            ->preservingOriginal()
                            ->toMediaCollection(config('media.collections.panoramas'));

                        $panoramas_count++;
                    });

                for ($i = 0; $i < ($location->panoramas->count() - 1); ++$i) {
                    $current = $location->panoramas[$i];
                    $next = $location->panoramas[$i + 1];

                    Link::create([
                        "heading" => 0,
                        "origin_id" => $current->id,
                        "destination_id" => $next->id,
                    ]);

                    Link::create([
                        "heading" => 180,
                        "origin_id" => $next->id,
                        "destination_id" => $current->id,
                    ]);
                }
            }
        });
    }
}
