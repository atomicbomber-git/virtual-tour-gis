<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Layer;

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
            'name' => 'string|required',
            'description' => 'string|required'
        ]);

        Layer::create($data);

        return redirect()
            ->route('layer.index')
            ->with(['message' => __('messages.create.success')]);
    }
    
    public function edit(Layer $layer)
    {
        return view('layer.edit', compact('layer'));
    }
    
    public function update(Layer $layer)
    {
        $data = $this->validate(request(), [
            'name' => 'string|required',
            'description' => 'string|required'
        ]);

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
