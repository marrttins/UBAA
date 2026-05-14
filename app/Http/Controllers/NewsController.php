<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\News;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::latest()->paginate(9);
        return view('news.index', compact('news'));
    }

    public function show($slug)
    {
        $article = News::where('slug', $slug)->orWhere('id', $slug)->firstOrFail();
        $recent_news = News::where('id', '!=', $article->id)->latest()->take(3)->get();
        return view('news.show', compact('article', 'recent_news'));
    }
}
