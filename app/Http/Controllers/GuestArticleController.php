<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;

class GuestArticleController extends Controller
{
    public function index()
    {
        $articles = Article::query()
            ->select("id", "title", "created_at")
            ->orderByDesc("created_at", "updated_at")
            ->paginate(5);

        return view("guest-article.index", compact("articles"));
    }

    public function show(Article $article)
    {
        return view("guest-article.show", compact("article"));;
    }
}
