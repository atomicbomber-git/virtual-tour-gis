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
            ->with('locations:id,layer_id,name,address,description,latitude,longitude')
            ->get();

        return view('location.index', compact('layers'));
    }
    
    public function create()
    {
        $layers = Layer::query()
            ->select('id', 'name')
            ->with('locations:id,layer_id,name,address,description,latitude,longitude')
            ->get();

        return view('location.create', compact('layers'));
    }
    
    public function store()
    {   
    }
    
    public function edit(Location $location)
    {
    }
    
    public function update(Location $location)
    {
        $data = $this->validate(request(), [
            'name' => 'required|string',
            'description' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric'
        ]);

        $location->update($data);

        session()->flash('message', __('messages.update.success'));
    }
    
    public function delete(Location $location) {
        $location->delete();
        session()->flash('message', __('messages.delete.success'));
    }
}
