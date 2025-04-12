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

    /**
     * Display a listing of the user's favorite items.
     */
    public function index()
    {
        $favorites = Favorite::where('user_id', Auth::id())->get();

        return view('favorites.index', compact('favorites'));
    }

    /**
     * Store a newly created favorite item.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'imdb_id' => 'required|string',
            'title'   => 'required|string',
            'year'    => 'required|string',
            'poster'  => 'required|url'
        ]);

        Favorite::firstOrCreate(
            [
                'user_id' => Auth::id(),
                'imdb_id' => $validated['imdb_id'],
            ],
            [
                'title'  => $validated['title'],
                'year'   => $validated['year'],
                'poster' => $validated['poster'],
            ]
        );

        return back()->with('success', __('Added to favorites'));
    }

    /**
     * Remove the specified favorite item.
     */
    public function destroy($id)
    {
        $favorite = Favorite::where('user_id', Auth::id())
            ->findOrFail($id);

        $favorite->delete();

        return back()->with('success', __('Removed from favorites'));
    }
}
