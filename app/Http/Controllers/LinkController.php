<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Location;
use App\Panorama;
use App\Link;

class LinkController extends Controller
{
    public function create(Location $location, Panorama $panorama)
    {
        $data = $this->validate(request(), [
            'destination_id' => 'required|exists:panoramas,id',
            'heading' => 'required|numeric'
        ]);

        $link = Link::create([
            'origin_id' => $panorama->id,
            'destination_id' => $data['destination_id'],
            'heading' => $data['heading']
        ]);

        return $link->load('destination');
    }

    public function update(Location $location, Panorama $panorama, Link $link)
    {
        $data = $this->validate(request(), [
            'heading' => 'required|numeric'
        ]);

        $link->update($data);
    }

    public function delete(Location $location, Panorama $panorama, Link $link)
    {
        $link->delete();
    }

}
