@extends('layouts.auth')

@section('content')
<div class="container">
    <div class="text-center mb-4">
        <a href="{{ route('home.index') }}">
            <img class="mb-4" src="{{ asset('/img/icon_circle_light.png') }}" alt="MultiCrew logo" width="72"
                height="72">
        </a>
        <h1 class="h3 mb-3 font-weight-normal text-white">Authorization Request</h1>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div >
                <div class="text-white">
                    <!-- Introduction -->
                    <p><strong>{{ $client->name }}</strong> is requesting permission to access your account.</p>

                    <!-- Scope List -->
                    @if (count($scopes) > 0)
                    <div class="scopes">
                        <p><strong>This application will be able to:</strong></p>

                        <ul>
                            @foreach ($scopes as $scope)
                            <li>{{ $scope->description }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <hr style="border-color: #fff;">

                    <div class="d-flex justify-content-between align-items-baseline mt-2 mb-3">
                        <!-- Cancel Button -->
                        <form method="post" action="{{ route('passport.authorizations.deny') }}">
                            @csrf
                            @method('DELETE')

                            <input type="hidden" name="state" value="{{ $request->state }}">
                            <input type="hidden" name="client_id" value="{{ $client->id }}">
                            <input type="hidden" name="auth_token" value="{{ $authToken }}">
                            <button class="btn btn-danger">Deny</button>
                        </form>
                        
                        <!-- Authorize Button -->
                        <form method="post" action="{{ route('passport.authorizations.approve') }}">
                            @csrf

                            <input type="hidden" name="state" value="{{ $request->state }}">
                            <input type="hidden" name="client_id" value="{{ $client->id }}">
                            <input type="hidden" name="auth_token" value="{{ $authToken }}">
                            <button type="submit" class="btn btn-success btn-approve">Authorize</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <p class="my-3 text-muted text-center">&copy; MultiCrew {{ date('Y') }}</p>
</div>
@endsection