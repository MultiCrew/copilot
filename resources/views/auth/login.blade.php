@extends('layouts.auth')

@section('content')

<form method="POST" action="{{ route('login') }}" class="form-signin">
    @csrf

    <div class="text-center mb-4">
        <a href="{{ route('home.index') }}">
            <img class="mb-4" src="{{ asset('/img/icon_circle_light.png') }}" alt="MultiCrew logo" width="72" height="72">
        </a>
        <h1 class="h3 mb-3 font-weight-normal text-white">Login</h1>
        <p class="text-white">
            A MultiCrew account is free and gives you
            access to all of our services!<br>
            <a href="{{ route('register') }}">Create Account &raquo;</a>
        </p>
    </div>

    <div class="form-label-group">
        <input type="text" id="identity" name="identity" class="form-control @error('identity') is-invalid @enderror"
            placeholder="Username or email" value="{{ old('identity') }}" required autocomplete="username" autofocus>
        <label for="identity">Username or email</label>
    </div>
    @error('identity')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror

    <div class="form-label-group">
        <input type="password" id="password" name="password"
            class="form-control @error('password') is-invalid @enderror" placeholder="Password" required
            autocomplete="current-password">
        <label for="password">Password</label>
    </div>
    @error('password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror

    <hr style="border-color: #fff;">

    <div class="checkbox mb-3">
        <label class="text-white">
            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} class="mr-2">
            Remember me
        </label>
    </div>

    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>

    <div class="d-flex justify-content-between align-items-baseline mt-2 mb-3">
        <p><a class="px-0" href="{{ url()->previous() }}">Back</a></p>
        @if(Route::has('password.request'))
            <p><a class="px-0" href="{{ route('password.request') }}">Forgot your password?</a></p>
        @endif
    </div>

    <p class="my-3 text-muted text-center">&copy; MultiCrew {{ date('Y') }}</p>
</form>

@endsection
