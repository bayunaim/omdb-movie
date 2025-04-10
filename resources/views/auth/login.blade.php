@extends('layouts.auth')

@section('content')
<div class="login-box">
    <h2>Welcome Back !</h2>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group mb-3">
            <label for="username">Username</label>
            <input id="username" type="text"
                class="form-control @error('username') is-invalid @enderror"
                name="username" value="{{ old('username') }}" required autofocus>
            @error('username')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="password">Password</label>
            <input id="password" type="password"
                class="form-control @error('password') is-invalid @enderror"
                name="password" required>
            @error('password')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="remember" id="remember"
                {{ old('remember') ? 'checked' : '' }}>
            <label class="form-check-label" for="remember">
                Remember Me
            </label>
        </div>

        <button type="submit" class="btn btn-primary w-100 mb-2">Login</button>
    </form>
</div>
@endsection
