<?php

namespace App\Http\Controllers;

use App\Destination;
use App\Layer;
use App\Location;
use App\Panorama;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class LocationController extends Controller
{
    public function index()
    {
        $layers = Layer::query()
            ->select(
                'layer_id',
                'name'
            )
            ->with([
                'locations' => function (HasMany $query) {
                    $query->select('id', 'layer_id', 'name', 'address', 'description', 'latitude', 'longitude', 'has_virtual_tour')
                        ->orderBy('name');
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
            'layer_id' => "required|exists:layers," . (new Layer)->getKeyName(),
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'has_virtual_tour' => 'required|boolean',
        ]);

        Location::create($data);
        session()->flash('message.success', __('messages.create.success'));;
    }

    public function update(Location $location)
    {
        $data = $this->validate(request(), [
            'name' => 'required|string',
            'address' => 'required|string',
            'description' => 'required|string',
            'layer_id' => "required|exists:layers," . (new Layer)->getKeyName(),
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'has_virtual_tour' => 'required|boolean',
        ]);

        $location->update($data);
        session()->flash('message.success', __('messages.update.success'));;
    }

    public function delete(Location $location)
    {


        DB::transaction(function () use ($location) {
            $location->load(['panoramas:id,location_id']);
            $panorama_ids = $location->panoramas->pluck('id');

            Destination::whereIn('origin_id', $panorama_ids)
                ->delete();

            Destination::whereIn('destination_id', $panorama_ids)
                ->delete();

            Panorama::where('location_id', $location->id)
                ->delete();

            $location->delete();
        });

        session()->flash('message.success', __('messages.delete.success'));;
    }

    public function panorama(Location $location)
    {

    }
}
