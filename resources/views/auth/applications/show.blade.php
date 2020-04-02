@extends('layouts.base')

@section ('content')

<div>
    <div class="form-group">
        <label>
            Please describe any relevant web and/or development experience you
            have, giving evidence of participation where appropriate.
        </label>
        <textarea class="form-control" readonly>{{ $application->software_dev }}</textarea>
    </div>

    <div class="form-group">
        <label>
            Please describe your flight simulation experience, particularly in
            relation to shared cockpit flying.
        </label>
        <textarea class="form-control" readonly>{{ $application->flight_sim }}</textarea>
    </div>

    <div class="form-group">
        <label>Do you fly online?</label>
        <div class="form-check">
            <input
            type="radio"
            class="form-check-input"
            disabled
            @if($application->online == 0) checked @endif>
            <label class="form-check-label">No</label>
        </div>
        <div class="form-check">
            <input
            type="radio"
            class="form-check-input"
            disabled
            @if($application->online == 'vatsim') checked @endif>
            <label class="form-check-label">Yes, on VATSIM</label>
        </div>
        <div class="form-check">
            <input
            type="radio"
            class="form-check-input"
            disabled
            @if($application->online == 'ivao') checked @endif>
            <label class="form-check-label">Yes, on IVAO</label>
        </div>
        <div class="form-check">
            <input
            type="radio"
            class="form-check-input"
            disabled
            @if($application->online == 'pe') checked @endif>
            <label class="form-check-label">Yes, on PilotEdge</label>
        </div>
    </div>
</div>

<form method="post" action="{{ route('admin.applications.edit', $application) }}">
    @method('patch')
    @csrf

    <p>
        <button type="submit" class="btn btn-success" value="approve">
            Approve<i class="fas fa-check ml-3"></i>
        </button>
        <button type="submit" class="btn btn-danger" value="reject">
            Reject<i class="fas fa-times ml-3"></i>
        </button>
    </p>
</form>

@endsection
