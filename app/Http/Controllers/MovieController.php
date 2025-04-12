<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OmdbService;
use App\Favorite;
use Auth;

class MovieController extends Controller
{
    protected OmdbService $omdb;

    public function __construct(OmdbService $omdb)
    {
        $this->middleware('auth');
        $this->omdb = $omdb;
    }

    /**
     * Display a list of movies based on user search or default.
     */
    public function index(Request $request)
    {
        $search = $request->get('s', '');
        $year   = $request->get('y', '');
        $type   = $request->get('type', '');
        $page   = $request->get('page', 1);

        $isEmptySearch = empty($search) && empty($year) && empty($type);

        // Prepare search parameters for the API
        $params = [
            's'    => $isEmptySearch ? 'Avengers' : $search,
            'page' => $page,
        ];

        if (!$isEmptySearch) {
            if (!empty($year)) $params['y'] = $year;
            if (!empty($type)) $params['type'] = $type;
        }

        // Fetch data from OMDb API
        $response      = $this->omdb->search($params);
        $movies        = $response['Search'] ?? [];
        $totalResults  = $response['totalResults'] ?? 0;

        // Return partial view for AJAX requests
        if ($request->ajax()) {
            return response()->json([
                'html'         => view('movies.partials.list', compact('movies'))->render(),
                'totalResults' => $totalResults,
            ]);
        }

        return view('movies.index', compact('movies', 'search', 'year', 'type', 'totalResults'));
    }

    /**
     * Display movie details by IMDb ID.
     */
    public function show(string $id)
    {
        $movie = $this->omdb->getById($id);

        $isFavorite = Favorite::where('user_id', Auth::id())
            ->where('imdb_id', $id)
            ->exists();

        return view('movies.show', compact('movie', 'isFavorite'));
    }
}
