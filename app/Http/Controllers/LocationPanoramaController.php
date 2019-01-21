<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Location;
use App\Panorama;

class LocationPanoramaController extends Controller
{
    public function index(Location $location)
    {
        $location->load('panoramas');
        return view('location.panorama.index', compact('location'));
    }
    
    public function create(Location $location)
    {
    }
    
    public function store(Location $location)
    {
        $data = $this->validate(request(), [
            'name' => 'string|required',
            'image' => 'file|required'
        ]);

        $data['location_id'] = $location->id;

        DB::transaction(function() use($data) {
            Panorama::create($data)
                ->addMediaFromRequest('image')
                ->toMediaCollection(config('media.collections.panoramas'));
        });

        return back()
            ->with('message.success', __('messages.create.success'));
    }

    public function image(Location $location, Panorama $panorama)
    {
        $image = $panorama->getFirstMedia(config('media.collections.panoramas'));
        if (empty($image)) { abort(404); }
        return response()->file($image->getPath());
    }

    public function tile(Location $location, Panorama $panorama, $zoom, $tile_x, $tile_y)
    {
        $image = $panorama->getFirstMedia(config('media.collections.panoramas'));
        if (empty($image)) { abort(404); }
        return response()->file($image->getPath("tile_${zoom}_${tile_x}_${tile_y}"));
    }

    public function edit(Location $location, Panorama $panorama)
    {
    }
    
    public function update(Location $location, Panorama $panorama)
    {
    }
    
    public function delete(Location $location, Panorama $panorama) {
        $panorama->delete();

        return back()
            ->with('message.success', __('messages.create.success'));
    }
}
