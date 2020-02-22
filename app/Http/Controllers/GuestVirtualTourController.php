<?php

namespace App\Http\Controllers;

use App\Layer;

class GuestVirtualTourController extends Controller
{
    public function show()
    {
        $layers = Layer::query()
            ->with("locations.panoramas.links.destination")
            ->get();

        return view('guest-virtual-tour.show', compact('layers'));
    }
}
