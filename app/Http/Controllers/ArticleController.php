<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::query()
            ->select("id", "title", "content")
            ->orderByDesc("created_at")
            ->orderByDesc("updated_at")
            ->paginate();

        return view("article.index", compact("articles"));
    }

    public function create()
    {
        return view("article.create");
    }

    public function store()
    {
        $data = $this->validate(request(), [
            "title" => "required|string",
            "content" => "required|string",
        ]);

        Article::create($data);

        return redirect()
            ->route("article.index")
            ->with("message.success", __("messages.create.success"));
    }

    public function edit(Article $article)
    {
        return view("article.edit", compact("article"));
    }

    public function update(Article $article)
    {
        $data = $this->validate(request(), [
            "title" => "required|string",
            "content" => "required|string",
        ]);

        $article->update($data);

        return back()
            ->with("message.success", __("messages.update.success"));
    }

    public function delete(Article $article)
    {
        $article->delete();

        return back()
            ->with("message.success", __("messages.delete.success"));
    }
}
