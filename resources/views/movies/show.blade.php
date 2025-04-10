@extends('layouts.app')

@section('title', $movie['Title'])

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4 mb-4">
            <img src="{{ $movie['Poster'] != 'N/A' ? $movie['Poster'] : asset('images/no-poster.jpg') }}"
                 class="img-fluid rounded" alt="{{ $movie['Title'] }}">
        </div>
        <div class="col-md-8">
            <h2>{{ $movie['Title'] }} ({{ $movie['Year'] }})</h2>

            <div class="mb-3">
                @if($isFavorite)
                    <form action="{{ route('favorites.destroy', Auth::user()->favorites->where('imdb_id', $movie['imdbID'])->first()->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fas fa-heart"></i> {{ __('messages.Remove from Favorites') }}
                        </button>
                    </form>
                @else
                    <form action="{{ route('favorites.store') }}" method="POST" class="d-inline">
                        @csrf
                        <input type="hidden" name="imdb_id" value="{{ $movie['imdbID'] }}">
                        <input type="hidden" name="title" value="{{ $movie['Title'] }}">
                        <input type="hidden" name="year" value="{{ $movie['Year'] }}">
                        <input type="hidden" name="poster" value="{{ $movie['Poster'] }}">
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="far fa-heart"></i> {{ __('messages.Add to Favorites') }}
                        </button>
                    </form>
                @endif
            </div>

            <div class="mb-3">
                <span class="badge badge-info">{{ $movie['Rated'] }}</span>
                <span class="badge badge-secondary">{{ $movie['Runtime'] }}</span>
                <span class="badge badge-primary">{{ $movie['Genre'] }}</span>
                <span class="badge badge-success">{{ $movie['Type'] }}</span>
            </div>

            <p>{{ $movie['Plot'] }}</p>

            <div class="row mt-4">
                <div class="col-md-6">
                    <h5>{{ __('messages.Details') }}</h5>
                    <ul class="list-unstyled">
                        <li><strong>{{ __('messages.Director') }}:</strong> {{ $movie['Director'] }}</li>
                        <li><strong>{{ __('messages.Writer') }}:</strong> {{ $movie['Writer'] }}</li>
                        <li><strong>{{ __('messages.Actors') }}:</strong> {{ $movie['Actors'] }}</li>
                        <li><strong>{{ __('messages.Language') }}:</strong> {{ $movie['Language'] }}</li>
                        <li><strong>{{ __('messages.Country') }}:</strong> {{ $movie['Country'] }}</li>
                        <li><strong>{{ __('messages.Awards') }}:</strong> {{ $movie['Awards'] }}</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h5>{{ __('messages.Ratings') }}</h5>
                    @foreach($movie['Ratings'] as $rating)
                        <div class="mb-2">
                            <strong>{{ $rating['Source'] }}:</strong> {{ $rating['Value'] }}
                        </div>
                    @endforeach
                    <div class="mt-3">
                        <strong>{{ __('messages.IMDb Rating') }}:</strong> {{ $movie['imdbRating'] }} ({{ $movie['imdbVotes'] }} votes)
                    </div>
                    <div class="mt-3">
                        <strong>{{ __('messages.Box Office') }}:</strong> {{ $movie['BoxOffice'] ?? 'N/A' }}
                    </div>
                    <div class="mt-3">
                        <strong>{{ __('messages.DVD Release') }}:</strong> {{ $movie['DVD'] ?? 'N/A' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
