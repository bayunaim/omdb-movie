@extends('layouts.app')

@section('title', __('messages.Movies'))

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card bg-dark text-white">
                <div class="card-header border-bottom border-secondary">
                    {{ __('messages.Search Movies') }}
                </div>
                <div class="card-body">
                    <form id="search-form">
                        <div class="form-row">
                            <div class="form-group col-md-5">
                                <input type="text" id="title" name="s" class="form-control bg-dark text-white border-secondary" placeholder="{{ __('messages.Title') }}" value="{{ $search ?? '' }}">
                            </div>
                            <div class="form-group col-md-3">
                                <input type="text" id="year" name="y" class="form-control bg-dark text-white border-secondary" placeholder="{{ __('messages.Year') }}" value="{{ $year ?? '' }}">
                            </div>
                            <div class="form-group col-md-3">
                                <select name="type" id="type" class="form-control bg-dark text-white border-secondary">
                                    <option value="">{{ __('messages.All Types') }}</option>
                                    <option value="movie" {{ isset($type) && $type == 'movie' ? 'selected' : '' }}>{{ __('messages.Movie') }}</option>
                                    <option value="series" {{ isset($type) && $type == 'series' ? 'selected' : '' }}>{{ __('messages.Series') }}</option>
                                    <option value="episode" {{ isset($type) && $type == 'episode' ? 'selected' : '' }}>{{ __('messages.Episode') }}</option>
                                </select>
                            </div>
                            <div class="form-group col-md-1">
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <h4>{{ __('messages.Movie List') }}</h4>
            <p class="text-muted total-results">
                @if(isset($totalResults))
                    {{ __('messages.found_results', ['total' => $totalResults]) }}
                @endif
            </p>
        </div>
    </div>

    <div id="movies-container" class="row">
        @include('movies.partials.list', ['movies' => $movies])
    </div>

    @if(empty($movies))
        <div class="empty-state">
            <i class="fas fa-film fa-4x mb-3"></i>
            <h4>{{ __('messages.No movies found') }}</h4>
            <p>{{ __('messages.Try searching for movies using the form above') }}</p>
        </div>
    @endif

    <div class="row mt-4">
        <div class="col-md-12 text-center">
            <div id="loading" class="d-none">
                <i class="fas fa-spinner fa-spin fa-2x"></i>
                <p>{{ __('messages.Loading more movies...') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        let page = 1;
        let loading = false;
        let hasMore = true;

        // Initialize lazy load
        var lazyLoadInstance = new LazyLoad({
            elements_selector: ".lazy"
        });

        // Handle form submission
        $('#search-form').on('submit', function(e) {
            e.preventDefault();
            page = 1;
            hasMore = true;
            $('#movies-container').empty();
            loadMovies();
        });

        // Infinite scroll
        $(window).scroll(function() {
            if ($(window).scrollTop() + $(window).height() >= $(document).height() - 300) {
                if (!loading && hasMore) {
                    loadMovies();
                }
            }
        });

        // Load movies
        function loadMovies() {
            if (loading) return;

            loading = true;
            $('#loading').removeClass('d-none');

            const formData = $('#search-form').serialize() + '&page=' + page;

            $.ajax({
                url: '{{ route("movies.index") }}',
                type: 'GET',
                data: formData,
                success: function(response) {
                    if (page === 1) {
                        $('.total-results').text(
                            '{{ __("messages.found_results", ["total" => ":total"]) }}'.replace(':total', response.totalResults)
                        );
                    }

                    if (page === 1 && $(response.html).find('.movie-card').length === 0) {
                        $('#movies-container').html(response.html);
                    } else if ($(response.html).find('.movie-card').length > 0) {
                        $('#movies-container').append(response.html);
                        $('.total-results').text(
                            '{{ __("messages.found_results", ["total" => ":total"]) }}'.replace(':total', response.totalResults)
                        );
                        lazyLoadInstance.update();
                        page++;
                    } else {
                        hasMore = false;
                    }
                },
                complete: function() {
                    loading = false;
                    $('#loading').addClass('d-none');
                }
            });
        }

        //toggle readonly
        function toggleControls() {
            if ($('#title').val().trim() === '') {
                $('#year').prop('readonly', true).val('');
                $('#type').prop('disabled', true).val('');
            } else {
                $('#year').prop('readonly', false);
                $('#type').prop('disabled', false);
            }
        }

        // Trigger saat halaman dimuat
        toggleControls();

        // Trigger saat user ngetik di title
        $('#title').on('input', toggleControls);
    });
</script>
@endsection
