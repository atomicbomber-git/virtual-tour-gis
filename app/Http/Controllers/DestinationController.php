<?php

namespace App\Http\Controllers;

use App\Destination;
use App\Location;
use App\Panorama;

class DestinationController extends Controller
{
    public function create(Location $location, Panorama $panorama)
    {
        $data = $this->validate(request(), [
            'destination_id' => 'required|exists:panoramas,id',
            'heading' => 'required|numeric'
        ]);

        $link = Destination::create([
            'origin_id' => $panorama->id,
            'destination_id' => $data['destination_id'],
            'heading' => $data['heading']
        ]);

        return $link->load('destination');
    }

    public function update(Location $location, Panorama $panorama, Destination $link)
    {
        $data = $this->validate(request(), [
            'heading' => 'required|numeric'
        ]);

        $link->update($data);
    }

    public function delete(Location $location, Panorama $panorama, Destination $link)
    {
        $link->delete();
    }

}
