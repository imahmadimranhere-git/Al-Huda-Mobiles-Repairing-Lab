@extends('layouts.auth')

@section('title', 'Login')

@section('content')
    <h4 class="auth-title text-center">Login</h4>
    <p class="auth-subtitle text-center">Welcome back — sign in to continue.</p>

    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <p class="mb-0">{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" name="remember" class="form-check-input" id="remember">
            <label class="form-check-label" for="remember">Remember me</label>
        </div>

        <button type="submit" class="btn btn-accent w-100">Login</button>
    </form>

    <p class="text-center mt-3 mb-0 auth-switch">
        Don't have an account? <a href="{{ route('register') }}">Register here</a>
    </p>
@endsection