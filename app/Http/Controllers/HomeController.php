<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Layer;

class HomeController extends Controller
{
    public function show()
    {
        $layers = Layer::query()
            ->with("locations.panoramas.links.destination")
            ->get();

        return view("home.show", compact("layers"));
    }
}
