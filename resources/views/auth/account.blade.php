@extends('layouts.base')

@section('content')

<h1>Your Account</h1>

<ul class="nav nav-tabs card-text" id="account" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#accountTab" role="tab">
            <i class="fas fa-fw mr-2 fa-user"></i>Account
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#notificationTab" role="tab">
            <i class="fas fa-fw mr-2 fa-bell"></i>Notification Settings
        </a>
    </li>
</ul>

<div class="tab-content card-text" id="account">
    <div class="tab-pane fade show active" id="accountTab" role="tabpanel">
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
                    @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
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
                @error('email')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
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
                    @error('password')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
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
        </form>
    </div>

    <div class="tab-pane fade" id="notificationTab" role="tabpanel">
        <form method="post" action="{{route('notifications.store')}}">
            @method('patch')
            @csrf

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="username">New Request</label>
                    <input
                    type="checkbox"
                    id="newRequest"
                    name="newRequest"
                    class="form-control"
                    readonly
                    value="">
                </div>
            </div>
        </form>
    </div>

</div>
@endsection
