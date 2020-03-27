@extends('layouts.base')

@section('content')

<div class="card mb-4">
    <div class="card-body">
        <h1 class="card-title">Your Account</h1>
        <div class="card-text">
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
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <h3 class="card-header">
                <i class="fas mr-3 fa-bell"></i>Notification Settings
            </h3>
            <div class="card-body">
                <p class="card-text">
                    Select the notifications which you wish to subscribe to
                </p>

                <form method="post" action="{{route('notifications.update')}}" id='notificationForm'>
                    @method('patch')
                    @csrf

                    <table class="table border">
                        <thead class="thead-light">
                            <tr>
                                <td></td>
                                <td><i class="fas mx-auto fa-bell"></i></td>
                                <td><i class="fas mx-auto fa-envelope"></i></td>
                                <td><i class="fas mx-auto fa-mobile-alt"></i></td>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td>My flight request is accepted</td>
                                <td>
                                    <input
                                    type="checkbox"
                                    id="requestAccepted"
                                    name="requestAccepted"
                                    class="form-check-input mx-auto"
                                    onchange="document.getElementById('notificationForm').submit()"
                                    value="1"
                                    {{$userNotifications->request_accepted ? 'checked' : ''}}>
                                </td>
                                <td>
                                    <input
                                    type="checkbox"
                                    id="requestAcceptedEmail"
                                    name="requestAcceptedEmail"
                                    class="form-check-input mx-auto"
                                    onchange="document.getElementById('notificationForm').submit()"
                                    value="1"
                                    {{$userNotifications->request_accepted_email ? 'checked' : ''}}>
                                </td>
                                <td>
                                    <input
                                    type="checkbox"
                                    id="requestAcceptedPush"
                                    name="requestAcceptedPush"
                                    class="form-check-input mx-auto"
                                    onchange="document.getElementById('notificationForm').submit()"
                                    value="1"
                                    {{$userNotifications->request_accepted_push ? 'checked' : ''}}>
                                </td>
                            </tr>

                            <tr>
                                <td>My flight plan has been reviewed</td>
                                <td>
                                    <input
                                    type="checkbox"
                                    id="planAccepted"
                                    name="planAccepted"
                                    class="form-check-input mx-auto"
                                    onchange="document.getElementById('notificationForm').submit()"
                                    value="1"
                                    {{$userNotifications->plan_accepted ? 'checked' : ''}}>
                                </td>
                                <td>
                                    <input
                                    type="checkbox"
                                    id="planAcceptedEmail"
                                    name="planAcceptedEmail"
                                    class="form-check-input mx-auto"
                                    onchange="document.getElementById('notificationForm').submit()"
                                    value="1"
                                    {{$userNotifications->plan_accepted_email ? 'checked' : ''}}>
                                </td>
                                <td>
                                    <input
                                    type="checkbox"
                                    id="planAcceptedPush"
                                    name="planAcceptedPush"
                                    class="form-check-input mx-auto"
                                    onchange="document.getElementById('notificationForm').submit()"
                                    value="1"
                                    {{$userNotifications->plan_accepted_push ? 'checked' : ''}}>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
