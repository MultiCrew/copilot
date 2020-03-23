@extends('layouts.base')

@section('content')
<div class="container">
    <div class="jumbotron">
        <h1 class="display-4">Beta Application</h1>
        <p class="lead">MultiCrew Copilot</p>
        <hr class="my-4">
        <p>
            Please fill out the following form. We aim to review applications
            within 48 hours of receiving them, and you will receive updates
            through your registered email address.
        </p>
    </div>

    <form method="post" action="{{ route('application.store') }}">
        <div class="form-group">
            <label>
                Please describe any relevant web and/or development experience you
                have, giving evidence of participation where appropriate.
            </label>
            <textarea name="software-dev" class="form-control"></textarea>
        </div>

        <div class="form-group">
            <label>
                Please describe your flight simulation experience, particularly in
                relation to shared cockpit flying.
            </label>
            <textarea name="flight-sim" class="form-control"></textarea>
        </div>

        <div class="form-group">
            <label>Do you fly online?</label>
            <div class="custom-control custom-radio">
                <input type="radio" id="online1" name="online" value="0" class="custom-control-input" checked>
                <label class="custom-control-label">No</label>
            </div>
            <div class="custom-control custom-radio">
                <input type="radio" id="online2" name="online" value="vatsim" class="custom-control-input">
                <label class="custom-control-label">Yes, on VATSIM</label>
            </div>
            <div class="custom-control custom-radio">
                <input type="radio" id="online2" name="online" value="ivao" class="custom-control-input">
                <label class="custom-control-label">Yes, on IVAO</label>
            </div>
            <div class="custom-control custom-radio">
                <input type="radio" id="online2" name="online" value="pe" class="custom-control-input">
                <label class="custom-control-label">Yes, on PilotEdge</label>
            </div>
        </div>

        <button type="submit" class="btn btn-primary btn-lg">
            Submit<i class="fas fa-angle-double-right ml-2"></i>
        </button>
    </form>
</div>
@endsection
