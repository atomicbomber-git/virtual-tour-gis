<?php

namespace App\Http\Controllers;

use App\Destination;
use App\Helpers\Math;
use App\Location;
use App\Panorama;
use Illuminate\Support\Facades\DB;

class DestinationController extends Controller
{
    /**
     * @param Location $location
     * @param Panorama $panorama
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Exception
     */
    public function create(Location $location, Panorama $panorama)
    {
        $data = $this->validate(request(), [
            'destination_id' => 'required|exists:panoramas,id',
            'heading' => 'required|numeric'
        ]);

        DB::beginTransaction();

        $destination = Destination::create([
            'origin_id' => $panorama->id,
            'destination_id' => $data['destination_id'],
            'heading' => $data['heading']
        ]);

        $reverseDestination = Destination::updateOrCreate([
            'origin_id' => $data['destination_id'],
            'destination_id' => $panorama->id,
        ], [
            "heading" => Math::fmod($data['heading'] - 180, 360),
        ]);

        DB::commit();

        return [
            $destination->load('destination'),
            $reverseDestination->load('destination'),
        ];
    }

    /**
     * @param Location $location
     * @param Panorama $panorama
     * @param Destination $destination
     * @return array
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Location $location, Panorama $panorama, Destination $destination)
    {
        $data = $this->validate(request(), [
            'heading' => 'required|numeric'
        ]);

        DB::beginTransaction();

        $destination->update($data);

        DB::commit();

        return $destination->load('destination');
    }

    public function delete(Location $location, Panorama $panorama, Destination $destination)
    {
        $destination->delete();
    }

}
