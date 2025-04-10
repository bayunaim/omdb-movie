@extends('layouts.app')

@section('title', __('messages.My Favorites'))

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <h4>{{ __('messages.My Favorite Movies') }}</h4>
        </div>
    </div>

    <div class="row">
        @forelse($favorites as $favorite)
        <div class="col-md-3 mb-4">
            <div class="card movie-card h-100">
                <a href="{{ route('movies.show', $favorite->imdb_id) }}">
                    <img class="card-img-top lazy"
                         data-src="{{ $favorite->poster != 'N/A' ? $favorite->poster : asset('images/no-poster.jpg') }}"
                         alt="{{ $favorite->title }}">
                </a>
                <div class="card-body">
                    <h5 class="card-title">{{ $favorite->title }}</h5>
                    <p class="card-text">
                        <small class="text-muted">{{ $favorite->year }}</small>
                    </p>
                </div>
                <div class="card-footer bg-white">
                    <form action="{{ route('favorites.destroy', $favorite->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger">
                            <i class="fas fa-trash"></i> {{ __('messages.Remove') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-md-12">
            <div class="empty-state">
                <i class="fas fa-heart fa-4x mb-3"></i>
                <h4>{{ __('messages.No favorite movies yet') }}</h4>
                <p>{{ __('messages.Start by adding some movies to your favorites list') }}</p>
                <a href="{{ route('movies.index') }}" class="btn btn-primary mt-3">
                    <i class="fas fa-search"></i> {{ __('messages.Browse Movies') }}
                </a>
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Initialize lazy load
        new LazyLoad({
            elements_selector: ".lazy"
        });
    });
</script>
@endsection
