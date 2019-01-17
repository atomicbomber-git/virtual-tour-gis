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
    }
    
    public function store()
    {   
    }
    
    public function edit(Layer $layer)
    {
    }
    
    public function update(Layer $layer)
    {
    }
    
    public function delete(Layer $layer) {
        $layer->delete();
        return back()
            ->with(['message' => __('messages.delete.success')]);
    }
}
