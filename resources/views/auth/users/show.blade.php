@extends('layouts.base')

@section('content')

<h1 class="mb-3">Your Account</h1>

<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="account-tab" data-toggle="pill" href="#account" role="tab">
            <i class="fas fa-fw mr-2 fa-user-cog"></i>Settings
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="notifications-tab" data-toggle="pill" href="#notifications" role="tab">
            <i class="fas fa-fw mr-2 fa-bell"></i>Notifications
        </a>
    </li>

    @role('new')
        <li class="nav-item">
            <a class="nav-link" id="application-tab" data-toggle="pill" href="#application" role="tab">
                <i class="fas fa-fw mr-2 fa-check"></i>Beta Application
            </a>
        </li>
    @endrole
</ul>

<div class="card">
    <div class="card-body tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active card-text" id="account" role="tabpanel">

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
                        value="{{ $user->username }}"
                        autocomplete="username">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="username">Full Name</label>
                        <input
                        type="text"
                        id="name"
                        name="name"
                        class="form-control"
                        value="{{ $user->name }}"
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
                        value="{{ $user->email }}"
                        autocomplete="email">
                    </div>
                    <div class="col-md-6">
                        <label for="roles">Role(s)</label>
                        <input
                        type="text"
                        id="roles"
                        name="roles"
                        class="form-control-plaintext"
                        readonly
                        value="{{ $role }}"
                        autocomplete="off">
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
            </form>
        </div>

        <div class="tab-pane fade show card-text" id="notifications" role="tabpanel">
            <h3 class="card-title">Channels</h3>
            <p class="card-text">
                You can customise how MultiCrew notifies you about particular
                events.
            </p>

            <form
            method="post"
            action="{{route('notifications.update')}}"
            id="notificationForm"
            class="mb-4">
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
                                {{$userNotifications->request_accepted ? 'checked' : ''}}>
                            </td>
                            <td>
                                <input
                                type="checkbox"
                                id="requestAcceptedPush"
                                name="requestAcceptedPush"
                                class="form-check-input mx-auto"
                                onchange="document.getElementById('notificationForm').submit()"
                                value="1"
                                {{$userNotifications->request_accepted ? 'checked' : ''}}>
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
                                {{$userNotifications->plan_accepted ? 'checked' : ''}}>
                            </td>
                            <td>
                                <input
                                type="checkbox"
                                id="planAcceptedPush"
                                name="planAcceptedPush"
                                class="form-check-input mx-auto"
                                onchange="document.getElementById('notificationForm').submit()"
                                value="1"
                                {{$userNotifications->plan_accepted ? 'checked' : ''}}>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>

            <h3 class="card-title">Subscriptions</h3>
            <p class="card-text">
                You can subscribe to notifications for airports and aircraft, so
                that when a new request is added for one of your subscriptions
                you will be notified by your specified channel above!
            </p>

            <div class="form-group">
                <label>Airports</label>
                <select
                name="airportSelect"
                id="airportSelect"
                class="selectpicker form-control"
                data-live-search="true"
                multiple>
                    @foreach ($airports as $airport)
                        <option value="{{$airport->icao}}" selected>
                            {{$airport->icao}} - {{$airport->name}}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Aircraft</label>
                <select
                name="aircraftSelect"
                id="aircraftSelect"
                class="selectpicker form-control"
                data-live-search="true"
                multiple>
                    @foreach ($aircrafts as $aircraft)
                        <option value="{{$aircraft->icao}}" selected>
                            {{$aircraft->icao}} - {{$aircraft->name}}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        @role('new')
            <div class="tab-pane fade show card-text" id="application" role="tabpanel">
                @can('apply to beta')
                    <p class="lead card-text">
                        Join the Copilot beta testing program now!
                    </p>
                    <p class="card-text">
                        Did you know you are eligible to apply for the beta
                        testing program for Copilot? You'll be part of the team
                        testing new features and generating new ideas.
                        Interested?
                    </p>
                    <a class="btn btn-success btn-lg card-text"
                    href="{{ route('account.apply') }}">
                        Apply Now<i class="fas fa-angle-double-right ml-2"></i>
                    </a>
                @endcan
                @cannot('apply to beta')
                    <div class="alert alert-info card-text">
                        <strong>
                            You have a pending application to the beta program
                        </strong>
                        <hr>
                        Keep an eye on your email inbox for updates!
                    </div>
                @endcannot
            </div>
        @endrole
    </div>
</div>

@endsection
