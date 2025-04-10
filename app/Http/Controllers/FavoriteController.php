<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Favorite;
use Auth;

class FavoriteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $favorites = Favorite::where('user_id', Auth::id())->get();
        return view('favorites.index', compact('favorites'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'imdb_id' => 'required',
            'title' => 'required',
            'year' => 'required',
            'poster' => 'required'
        ]);

        $favorite = Favorite::firstOrCreate([
            'user_id' => Auth::id(),
            'imdb_id' => $request->imdb_id
        ], [
            'title' => $request->title,
            'year' => $request->year,
            'poster' => $request->poster
        ]);

        return back()->with('success', __('Added to favorites'));
    }

    public function destroy($id)
    {
        $favorite = Favorite::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $favorite->delete();

        return back()->with('success', __('Removed from favorites'));
    }
}
