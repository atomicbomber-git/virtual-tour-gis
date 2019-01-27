<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Location;
use App\Panorama;
use App\Layer;
use App\Link;

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
        

        DB::transaction(function() use($location) {
            $location->load(['panoramas:id,location_id']);
            $panorama_ids = $location->panoramas->pluck('id');

            Link::whereIn('origin_id', $panorama_ids)
                ->delete();

            Link::whereIn('destination_id', $panorama_ids)
                ->delete();

            Panorama::where('location_id', $location->id)
                ->delete();

            $location->delete();
        });

        session()->flash('message', __('messages.delete.success'));
    }

    public function panorama(Location $location) {
        
    }
}
