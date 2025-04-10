<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OmdbService;
use App\Favorite;
use Auth;

class MovieController extends Controller
{
    protected $omdb;

    public function __construct(OmdbService $omdb)
    {
        $this->omdb = $omdb;
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $search = $request->get('s', '');
        $year = $request->get('y', '');
        $type = $request->get('type', '');
        $page = $request->get('page', 1);

        $movies = [];
        $totalResults = 0;

        // Cek apakah semua parameter pencarian kosong
        $isEmptySearch = empty($search) && empty($year) && empty($type);

        $params = [];

        if ($isEmptySearch ) {
            // Pakai default search
            $params['s'] = 'Avengers';
            $params['page'] = $page;
        } else {
            // Pakai parameter dari user
            if ($search) $params['s'] = $search;
            if ($year) $params['y'] = $year;
            if ($type) $params['type'] = $type;
            $params['page'] = $page;
        }

        // Ambil data dari API
        $response = $this->omdb->search($params);
        $movies = $response['Search'] ?? [];
        $totalResults = $response['totalResults'] ?? 0;

        // Untuk AJAX
        if ($request->ajax()) {
            return response()->json([
                'html' => view('movies.partials.list', compact('movies'))->render(),
                'totalResults' => $totalResults,
            ]);
        }

        return view('movies.index', compact('movies', 'search', 'year', 'type', 'totalResults'));
    }

    public function show($id)
    {
        $movie = $this->omdb->getById($id);
        $isFavorite = Favorite::where('user_id', Auth::id())
            ->where('imdb_id', $id)
            ->exists();

        return view('movies.show', compact('movie', 'isFavorite'));
    }
}
