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

    <div class="form-group">
        <label for="email">Email Address</label>
        <input
        type="email"
        id="email"
        name="email"
        class="form-control"
        value="{{ Auth::user()->email }}"
        autocomplete="email">
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="password">Password</label>
            <input
            type="password"
            id="password"
            name="password"
            class="form-control"
            autocomplete="new-password">
            <small class="form-text">Leave blank to keep current password!</small>
        </div>

        <div class="form-group col-md-6">
            <label for="password_conf">Confirm Password</label>
            <input
            type="password"
            id="password_conf"
            name="password_conf"
            class="form-control"
            autocomplete="new-password">
        </div>
    </div>

    <button type="submit" class="btn btn-success">
        <i class="fas fa-fw fa-save mr-3"></i>Save
    </button>
</form>

@endsection
