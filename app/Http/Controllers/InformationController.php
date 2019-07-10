<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Information;

class InformationController extends Controller
{
    public function show($type)
    {
        $information = Information::where([
            "type" => $type
        ])->first();

        $information === null && abort(404);

        return view("information.show", compact("information"));
    }

    public function edit($type)
    {
        $information = Information::where([
            "type" => $type
        ])->first();

        $information === null && abort(404);

        return view("information.edit", compact("information"));
    }

    public function update($type)
    {
        $information = Information::where([
            "type" => $type
        ])->first();

        $data = $this->validate(request(), [
            "content" => "required|string",
        ]);

        $information->update([
            "content" => $data["content"]
        ]);

        return back()
            ->with("message.success", __("messages.update.success"));
    }
}
