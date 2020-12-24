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
    <li class="nav-item">
        <a class="nav-link" id="discord-tab" data-toggle="pill" href="#discord" role="tab">
            <i class="fab fa-fw mr-2 fa-discord"></i>Discord
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" id="tokens-tab" data-toggle="pill" href="#tokens" role="tab">
            <i class="fas fa-fw mr-2 fa-people-arrows"></i>Third Party Applications
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" id="api-tab" data-toggle="pill" href="#api" role="tab">
            <i class="fas fa-fw mr-2 fa-laptop-code"></i>API
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

            <form method="post" action="{{route('account.update')}}">
                @method('patch')
                @csrf

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username"
                            class="form-control @error('username') is-invalid @enderror" readonly
                            value="{{ $user->username }}" autocomplete="username">
                        @error('username')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="username">Full Name</label>
                        <input type="text" id="name" name="name"
                            class="form-control @error('name') is-invalid @enderror" value="{{ $user->name }}"
                            autocomplete="name">
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group form-row">
                    <div class="col-md-6">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email"
                            class="form-control @error('email') is-invalid @enderror" value="{{ $user->email }}"
                            autocomplete="email">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="roles">Role(s)</label>
                        <input type="text" id="roles" name="roles" class="form-control-plaintext" readonly
                            value="{{ $role }}" autocomplete="off">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="password">New Password</label>
                        <input type="password" id="password" name="password"
                            class="form-control @error('password') is-invalid @enderror" autocomplete="new-password">
                        <small class="form-text">Leave blank to keep current password!</small>
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="form-control" autocomplete="new-password">
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

            <form method="post" action="{{route('notifications.update')}}" id="notificationForm" class="mb-4">
                @csrf

                <table class="table border">
                    <thead class="thead-light">
                        <tr>
                            <td></td>
                            <td><i class="fas mx-auto fa-bell"></i></td>
                            <td><i class="fas mx-auto fa-envelope"></i></td>
                            <td><i class="fab mx-auto fa-discord"></i></td>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>My flight request is accepted</td>
                            <td>
                                <input type="checkbox" id="request_accepted" name="request_accepted"
                                    class="form-check-input mx-auto" onchange="postNotification()" value="1"
                                    {{ $userNotifications->request_accepted ? 'checked' : '' }}>
                            </td>
                            <td>
                                <input type="checkbox" id="request_accepted_email" name="request_accepted_email"
                                    class="form-check-input mx-auto" onchange="postNotification()" value="1"
                                    {{ $userNotifications->request_accepted_email ? 'checked' : '' }}>
                            </td>
                            <td>
                                <input type="checkbox" id="request_accepted_push" name="request_accepted_push"
                                    class="form-check-input mx-auto" onchange="postNotification()" value="1"
                                    {{ $userNotifications->request_accepted_push ? 'checked' : '' }}>
                            </td>
                        </tr>

                        <tr>
                            <td>My flight plan has been reviewed</td>
                            <td>
                                <input type="checkbox" id="plan_reviewed" name="plan_reviewed"
                                    class="form-check-input mx-auto" onchange="postNotification()" value="1"
                                    {{ $userNotifications->plan_reviewed ? 'checked' : ''}}>
                            </td>
                            <td>
                                <input type="checkbox" id="plan_reviewed_email" name="plan_reviewed_email"
                                    class="form-check-input mx-auto" onchange="postNotification()" value="1"
                                    {{ $userNotifications->plan_reviewed_email ? 'checked' : '' }}>
                            </td>
                            <td>
                                <input type="checkbox" id="plan_reviewed_push" name="plan_reviewed_push"
                                    class="form-check-input mx-auto" onchange="postNotification()" value="1"
                                    {{ $userNotifications->plan_reviewed_push ? 'checked' : '' }}>
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
                <select name="airportSelect" id="airportSelect" class="selectpicker form-control"
                    data-live-search="true" multiple>
                    @foreach ($airports as $airport)
                    <option value="{{$airport->icao}}" selected>
                        {{$airport->icao}} - {{$airport->name}}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Aircraft</label>
                <select name="aircraftSelect" id="aircraftSelect" class="selectpicker form-control"
                    data-live-search="true" multiple>
                    @foreach ($aircrafts as $aircraft)
                    <option value="{{$aircraft->icao}}" selected>
                        {{$aircraft->icao}} - {{$aircraft->name}}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="tab-pane fade show card-text" id="discord" role="tabpanel">
            <p class="card-text">
                Some of MultiCrew's services are integrated with Discord. We
                deliver push notifications to your Discord account, so you can
                get these through your web broswer, desktop or mobile app.
            </p>
            @if(!$user->discord_id)
            <dl>
                <dt>Status</dt>
                <dd>Not connected</dd>
            </dl>

            <a class="btn btn-lg btn-primary" role="button" href="{{ route('home.discord.redirect') }}">
                <i class="fas fa-link mr-2"></i>Connect to Discord
            </a>
            @else
            <dl>
                <dt>Status</dt>
                <dd>Connected to Discord with Client ID: {{ $user->discord_id }}</dd>
            </dl>

            <a class="btn btn-lg btn-danger" role="button" href="{{ route('home.discord.disconnect') }}">
                <i class="fas fa-unlink mr-2"></i>Disconnect from Discord
            </a>
            @endif
        </div>

        <div class="tab-pane fade show card-text" id="tokens" role="tabpanel">
            <div class="d-flex justify-content-between">
                <p class="class-text">
                    View all the third party applications that you have authorized to perform actions on your behalf.
                    You are able to revoke their access to your account by clicking on the name of the application.
                </p>
            </div>
            @if ($tokens)
            <div class="card-columns">
                @foreach ($tokens as $token)
                <div class="card shadow cursor-pointer h-100" id="card-{{$token['id']}}">
                    <div class="card-body">
                        <a onclick="showConfirmation({{json_encode($token['id'])}})" href="javascript:void(0)">
                            <div class="card-title">
                                {{$token['client']['name']}}
                            </div>
                        </a>
                        <button hidden id="confirm-{{$token['id']}}" type="button" class="btn btn-danger"
                            onclick="revokeToken({{json_encode($token['id'])}})">Confirm</button>
                    </div>
                    <div class="card-footer text-muted">
                        {{Carbon\Carbon::parse($token['created_at'])->format('d/m/Y')}}
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>

        <div class="tab-pane fade show card-text" id="api" role="tabpanel">
            <div class="d-flex justify-content-between">
                <p class="class-text">
                    Create clients to allow your third party applications access to the MultiCrew API.
                    <br>
                    Find more information on the <a href="{{config('app.url')}}/docs">MultiCrew Documentation page</a>.
                </p>

                <p class="class-text">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createClientModal">
                        <i class="fas fa-fw mr-2 fa-plus"></i> Create Client
                    </button>
                </p>
            </div>
            @if ($clients)
            <div class="card-columns">
                @foreach ($clients as $client)
                <div class="card shadow cursor-pointer h-100" id="card-{{$client['id']}}">
                    <a onclick="showModal({{json_encode($client)}})" class="stretched-link text-decoration-none">
                        <div class="card-body">
                            <div class="card-title">
                                {{$client['name']}}
                            </div>
                        </div>
                        <div class="card-footer text-muted">
                            {{Carbon\Carbon::parse($client['created_at'])->format('d/m/Y')}}
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
            @endif

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
            <a class="btn btn-success btn-lg card-text" href="{{ route('apply.create') }}">
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

@include('auth.users.client.create')
@include('auth.users.client.show')

@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/ajax-bootstrap-select/1.4.5/js/ajax-bootstrap-select.min.js">
</script>
<script type="text/javascript">
    $(document).ready(function() {
        var hash = window.location.hash;
        hash && $('ul.nav a[href="' + hash + '"]').tab('show');

        if ($('#request_accepted').prop('checked') !== true) {
            $("#request_accepted_email").attr("disabled", true);
            $("#request_accepted_push").attr("disabled", true);
        }

        if ($('#plan_reviewed').prop('checked') !== true) {
            $("#plan_reviewed_email").attr("disabled", true);
            $("#plan_reviewed_push").attr("disabled", true);
        }

        $('#request_accepted').click(function() {
            if ($(this).is(":checked")) {
                $("#request_accepted_email").removeAttr('disabled');
                $("#request_accepted_push").removeAttr('disabled');
            }
            else if ($(this).is(":not(:checked)")) {
                $("#request_accepted_email").attr("disabled", true);
                $("#request_accepted_push").attr("disabled", true);
            }
        });

        $('#plan_reviewed').click(function() {
            if ($(this).is(":checked")) {
                $("#plan_reviewed_email").removeAttr('disabled');
                $("#plan_reviewed_push").removeAttr('disabled');
            }
            else if ($(this).is(":not(:checked)")) {
                $("#plan_reviewed_email").attr("disabled", true);
                $("#plan_reviewed_push").attr("disabled", true);
            }
        });

    	$('#airportSelect').selectpicker({
    		liveSearch: true
    	})
    	.ajaxSelectPicker({
    		ajax: {
    			url: '{{ route("search.airport") }}',
    			method: 'GET',
    			data: {
    				q: '@{{{q}}}'
    			}
    		},
    		locale: {
    			emptyTitle: 'Start typing to search...',
    			statusInitialized: '',
    		},
    		preprocessData: function(data) {
    			var airports = [];
    			let count;
    			if(data.length > 0){
    				if (data.length >= 10) {
    					count = 10;
    				} else {
    					count = data.length;
    				}
    				for (var i = 0; i < count; i++) {
    					var curr = data[i];
    					airports.push({
							'value': curr.icao,
							'text': curr.icao + ' - ' + curr.name,
							'disabled': false
						});
    				}
    			}
    			return airports;
    		},
    		preserveSelected: true
    	});
    	$('#airportSelect').on('changed.bs.select', function(event, clickedIndex, isSelected, previousValue) {
    		$.ajax({
    			url: '{{ route("notifications.airport") }}',
    			type: 'POST',
    			data: {
    				'_token': "{{ csrf_token() }}",
    				'data': $('#airportSelect').selectpicker('val')
    			}
    		});
    	});

    	$('#aircraftSelect').selectpicker({
    		liveSearch: true
    	})
    	.ajaxSelectPicker({
    		ajax: {
    			url: '{{ route("search.aircraft") }}',
    			method: 'GET',
    			data: {
    				q: '@{{{q}}}'
    			}
    		},
    		locale: {
    			emptyTitle: 'Start typing to search...',
    			statusInitialized: '',
    		},
    		preprocessData: function(data) {
    			var aircrafts = [];
    			let count;
    			if(data.length > 0){
    				if (data.length >= 10) {
    					count = 10;
    				} else {
    					count = data.length;
    				}
    				for (var i = 0; i < count; i++) {
    					var curr = data[i];
    					aircrafts.push({
							'value': curr.icao,
							'text': curr.icao + ' - ' + curr.name,
							'disabled': false
						});
    				}
    			}
    			return aircrafts;
    		},
    		preserveSelected: true
    	});
    	$('#aircraftSelect').on('changed.bs.select', function(event, clickedIndex, isSelected, previousValue) {
    		$.ajax({
    			url: '{{ route("notifications.aircraft") }}',
    			type: 'POST',
    			data: {
    				'_token': "{{ csrf_token() }}",
    				'data': $('#aircraftSelect').selectpicker('val')
    			}
    		});
    	});
    });

    function postNotification() {
        $.ajax({
            url: '{{route("notifications.update")}}',
            type: 'POST',
            data: new FormData(document.getElementById('notificationForm')),
            processData: false,
            contentType: false
        })
    }

    function checkUsage(val){
        var element = document.getElementById('otherUsage');
        if(val == 'other') {
            element.style.display='block';
        } else {
            element.value = val;
            element.style.display='none';
        }
    }

    function showModal(client) {
        $('#client_show_name').val(client.name);
        $('#client_show_id').val(client.id);
        $('#client_show_secret').val(client.secret);
        client.redirect = client.redirect.replaceAll(',', '\n')
        $('#client_show_redirect').val(client.redirect);
        $('#showClientModal').modal('show')
    }

    function showConfirmation(token) {
        $(`#confirm-${token}`).removeAttr('hidden');
    }

    function revokeToken(token) {
        axios.delete('/oauth/tokens/' + token).then(res => {
            window.location.href = '/account#tokens';
            window.location.reload(true);
        });
    }

    $('#showClientModal').on('hide.bs.modal', function() {
        $('#client_show_secret').attr('hidden', true);
        $('#show_secret').removeAttr('hidden');
    })
</script>
@endsection
