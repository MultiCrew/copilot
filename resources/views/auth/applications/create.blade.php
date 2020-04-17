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

    <form method="post" action="{{ route('apply.store') }}">
    @csrf
        <div class="form-group">
            <label>
                Please describe any relevant web and/or development experience you
                have, giving evidence of participation where appropriate.
            </label>
            <textarea name="software_dev" class="form-control"></textarea>
        </div>

        <div class="form-group">
            <label>
                Please describe your flight simulation experience, particularly in
                relation to shared cockpit flying.
            </label>
            <textarea name="flight_sim" class="form-control"></textarea>
        </div>

        <div class="form-group">
            <label>Do you fly online?</label>
            <div class="form-check">
                <input type="radio" id="online1" name="online" value="0" class="form-check-input" checked>
                <label class="form-check-label">No</label>
            </div>
            <div class="form-check">
                <input type="radio" id="online2" name="online" value="vatsim" class="form-check-input">
                <label class="form-check-label">Yes, on VATSIM</label>
            </div>
            <div class="form-check">
                <input type="radio" id="online2" name="online" value="ivao" class="form-check-input">
                <label class="form-check-label">Yes, on IVAO</label>
            </div>
            <div class="form-check">
                <input type="radio" id="online2" name="online" value="pe" class="form-check-input">
                <label class="form-check-label">Yes, on PilotEdge</label>
            </div>
        </div>

        <button type="submit" class="btn btn-primary btn-lg">
            Submit<i class="fas fa-angle-double-right ml-2"></i>
        </button>
    </form>
</div>
@endsection
