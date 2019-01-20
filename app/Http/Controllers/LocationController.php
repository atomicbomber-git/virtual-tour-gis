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
            ->with([
                'locations' => function ($query) {
                    $query->select('id' ,'layer_id' ,'name' ,'address' ,'description' ,'latitude' ,'longitude');
                    $query->orderBy('name');
                }
            ])
            ->orderBy('name')
            ->get();

        return view('location.index', compact('layers'));
    }
    
    public function store()
    {
        $data = $this->validate(request(), [
            'name' => 'required|string',
            'address' => 'required|string',
            'description' => 'required|string',
            'layer_id' => 'required|exists:layers,id',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric'
        ]);
        
        Location::create($data);
        session()->flash('message', __('messages.create.success'));
    }
    
    public function update(Location $location)
    {
        $data = $this->validate(request(), [
            'name' => 'required|string',
            'address' => 'required|string',
            'description' => 'required|string',
            'layer_id' => 'required|exists:layers,id',
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
