@extends('mail.layouts.base')

@section('title', 'Beta Testing Application')
@section('subtitle', 'Application Review Result')

@section('name', $user->name)

@section('content')

@if($result === 'approved')

    <p class="lead">Congratulations</p>

    <p>
        Your application to join the beta testing team has been approved. Your
        MultiCrew account has been given new permissions and you should have
        have access to the Copilot system.
    </p>

    <p>
        Please now ensure that your account is connected to Discord in order to
        get access to the development discussion channels. This can be done in
        <a href="{{ route('account.index') }}">your account</a>.
    </p>

@else

    <p>
        Unfortunately, your application to join the beta testing team was not
        approved. Please feel free to submit another application, should you
        wish.
    </p>

@endif

@endsection
