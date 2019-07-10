<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Layer;
use App\Article;
use Html2Text\Html2Text;

class HomeController extends Controller
{
    public function show()
    {
        $layers = Layer::query()
            ->with("locations.panoramas.links.destination")
            ->get();

        $articles = Article::query()
            ->select("id", "title", "created_at", "content")
            ->latest()
            ->limit(3)
            ->get();

        return view("home.show", compact("layers", "articles"));
    }
}
