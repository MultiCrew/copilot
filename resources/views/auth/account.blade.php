@extends('layouts.base')

@section('content')

<h1>Your Account</h1>

<form method="post" action="">
    @method('patch')
    @csrf

    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="username">Username</label>
            <input
            type="text"
            id="username"
            name="username"
            class="form-control"
            readonly
            value="{{ Auth::user()->username }}"
            autocomplete="username">
        </div>

        <div class="form-group col-md-6">
            <label for="username">Full Name</label>
            <input
            type="text"
            id="name"
            name="name"
            class="form-control"
            value="{{ Auth::user()->name }}"
            autocomplete="name">
        </div>
    </div>

    <div class="form-group form-row">
        <div class="col-md-6">
            <label for="email">Email Address</label>
            <input
            type="email"
            id="email"
            name="email"
            class="form-control"
            value="{{ Auth::user()->email }}"
            autocomplete="email">
        </div>
        <div class="col-md-6">
            <label for="username">Role(s)</label>
            <input
            type="text"
            id="username"
            name="username"
            class="form-control"
            readonly
            value="@foreach(Auth::user()->roles as $role) {{ $role->name.' ' }} @endforeach"
            autocomplete="username">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="password">New Password</label>
            <input
            type="password"
            id="password"
            name="password"
            class="form-control"
            autocomplete="new-password">
            <small class="form-text">Leave blank to keep current password!</small>
        </div>

        <div class="form-group col-md-6">
            <label for="password_confirmation">Confirm Password</label>
            <input
            type="password"
            id="password_confirmation"
            name="password_confirmation"
            class="form-control"
            autocomplete="new-password">
        </div>
    </div>

    <button type="submit" class="btn btn-success">
        <i class="fas fa-fw fa-save mr-3"></i>Save
    </button>

    @cannot('search')
        <hr>
        <h3>Beta Application</h3>
        <p class="lead">Join the Copilot beta testing program now!</p>
        <p>
            Did you know you are eligible to apply for the beta testing program
            for Copilot? You'll be part of the team testing new features and
            generating new ideas. Interested?
        </p>
        <a class="btn btn-success btn-lg"
        href="{{ route('account.apply') }}">
            Apply Now<i class="fas fa-angle-double-right ml-2"></i>
        </a>
    @endcan
</form>

@endsection
