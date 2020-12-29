@extends('layouts.auth')

@section('content')

<form method="POST" action="{{ route('register') }}" class="form-signin">
    @csrf

    <div class="text-center mb-4">
        <a href="{{ route('home.index') }}">
            <img class="mb-4" src="{{ asset('/img/icon_circle_light.png') }}" alt="MultiCrew logo" width="72" height="72">
        </a>
        <h1 class="h3 mb-3 font-weight-normal text-white">Register</h1>
        <p class="text-white">
            <a href="{{ route('login') }}">
                Already have an account?
            </a>
        </p>
    </div>

    <div class="form-label-group">
        <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"
            placeholder="Name" value="{{ old('name') }}" required autocomplete="name" autofocus>
        <label for="name">Name</label>
    </div>
    @error('name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror

    <div class="form-label-group">
        <input type="text" id="username" name="username" class="form-control @error('username') is-invalid @enderror"
            placeholder="Username" value="{{ old('username') }}" required autocomplete="username">
        <label for="username">Username</label>
    </div>
    @error('username')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror

    <div class="form-label-group">
        <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror"
            placeholder="Email address" value="{{ old('email') }}" required autocomplete="email">
        <label for="email">Email address</label>
    </div>
    @error('email')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror

    <hr style="border-color: #fff;">

    <div class="form-label-group">
        <input type="password" id="password" name="password"
            class="form-control @error('password') is-invalid @enderror" placeholder="Password" required
            autocomplete="new-password">
        <label for="password">Password</label>
    </div>
    @error('password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror

    <div class="form-label-group">
        <input type="password" id="password_confirmation" name="password_confirmation"
            class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Confirm password"
            required autocomplete="new-password">
        <label for="password_confirmation">Confirm password</label>
    </div>
    @error('password_confirmation')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror

    <hr style="border-color: #fff;">

    {!! NoCaptcha::display() !!}
    @error('g-recaptcha-response')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror

    <div class="checkbox mb-3">
        <label class="text-white">
            <input type="checkbox" required class="mr-2">I accept the
            <a href="{{ route('home.policy') }}">Terms and Policies</a>.
        </label>
    </div>

    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign up</button>
    <p class="mt-2 mb-3"><a class="mx-0" href="{{ url()->previous() }}">Back</a></p>

    <p class="my-3 text-muted text-center">&copy; MultiCrew {{ date('Y') }}</p>
</form>

@endsection

@section('scripts', )
    {!! NoCaptcha::renderJs() !!}
@endsection
