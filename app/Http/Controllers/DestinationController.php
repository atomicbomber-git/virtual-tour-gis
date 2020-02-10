<?php

namespace App\Http\Controllers;

use App\Destination;
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

        $reverseDestination = Destination::firstOrCreate([
            'origin_id' => $data['destination_id'],
            'destination_id' => $panorama->id,
        ], [
            'heading' => $data['heading'] - 180,
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
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Location $location, Panorama $panorama, Destination $destination)
    {
        $data = $this->validate(request(), [
            'heading' => 'required|numeric'
        ]);

        $destination->update($data);
    }

    public function delete(Location $location, Panorama $panorama, Destination $destination)
    {
        $destination->delete();
    }

}
