<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Layer;
use Illuminate\Support\Facades\DB;

class LayerController extends Controller
{
    public function index()
    {
        $layers = Layer::select('id', 'name', 'description')
            ->orderBy('name')
            ->get();

        return view('layer.index', compact('layers'));
    }
    
    public function create()
    {
        return view('layer.create');
    }
    
    public function store()
    {
        $data = $this->validate(request(), [
            'name' => 'required|string',
            'description' => 'required|string',
            'icon' => 'required|file|mimes:png,jpg,jpeg'
        ]);
        
        DB::transaction(function() use($data) {
            Layer::create($data)
                ->addMediaFromRequest('icon')
                ->toMediaCollection(config('media.collections.icons'));
        });

        return redirect()
            ->route('layer.index')
            ->with(['message' => __('messages.create.success')]);
    }
    
    public function edit(Layer $layer)
    {
        return view('layer.edit', compact('layer'));
    }

    public function icon(Layer $layer)
    {
        $image = $layer->getFirstMedia(config('media.collections.icons'));
        if (empty($image)) { abort(404); }
        return response()->file($image->getPath());
    }
    
    public function update(Layer $layer)
    {
        $data = $this->validate(request(), [
            'name' => 'string|required',
            'description' => 'string|required',
            'icon' => 'nullable|file'
        ]);

        $layer->clearMediaCollection(config('media.collections.icons'));
        $layer->addMediaFromRequest('icon')
            ->toMediaCollection(config('media.collections.icons'));

        $layer->update($data);

        return redirect()
            ->route('layer.index')
            ->with(['message' => __('messages.update.success')]);
    }
    
    public function delete(Layer $layer) {
        $layer->delete();
        return back()
            ->with(['message' => __('messages.delete.success')]);
    }
}
