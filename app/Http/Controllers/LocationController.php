<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Location;
use App\Layer;

class LocationController extends Controller
{
    public function index()
    {
        $layers = Layer::query()
            ->select('id', 'name')
            ->with('locations:id,layer_id,name,latitude,longitude')
            ->get();

        return view('location.index', compact('layers'));
    }
    
    public function create()
    {
    }
    
    public function store()
    {   
    }
    
    public function edit(Location $location)
    {
    }
    
    public function update(Location $location)
    {
    }
    
    public function delete(Location $location) {
    }
}
