@foreach($movies as $movie)
<div class="col-md-3 mb-4">
    <div class="card movie-card h-100">
        <a href="{{ route('movies.show', $movie['imdbID']) }}">
            <img class="card-img-top lazy"
                 data-src="{{ $movie['Poster'] != 'N/A' ? $movie['Poster'] : asset('images/no-poster.jpg') }}"
                 alt="{{ $movie['Title'] }}">
        </a>
        <div class="card-body">
            <h5 class="card-title">{{ $movie['Title'] }}</h5>
            <p class="card-text">
                <small class="text-muted">{{ $movie['Year'] }} • {{ ucfirst($movie['Type']) }}</small>
            </p>
        </div>
        <div class="card-footer bg-white">
            <form action="{{ route('favorites.store') }}" method="POST">
                @csrf
                <input type="hidden" name="imdb_id" value="{{ $movie['imdbID'] }}">
                <input type="hidden" name="title" value="{{ $movie['Title'] }}">
                <input type="hidden" name="year" value="{{ $movie['Year'] }}">
                <input type="hidden" name="poster" value="{{ $movie['Poster'] }}">
                <button type="submit" class="btn btn-sm btn-outline-primary">
                    <i class="far fa-heart"></i> {{ __('messages.Favorite') }}
                </button>
            </form>
        </div>
    </div>
</div>
@endforeach
