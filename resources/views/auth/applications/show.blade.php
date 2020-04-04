@extends('layouts.base')

@section ('content')

<h1>Beta Application</h1>

<div class="form-row">
    <div class="form-group col-md-4">
        <label>Full Name</label>
        <input type="text" readonly class="form-control" value="{{ $application->user->name }}">
    </div>
    <div class="form-group col-md-4">
        <label>Username</label>
        <input type="text" readonly class="form-control" value="{{ $application->user->username }}">
    </div>
    <div class="form-group col-md-4">
        <label>Email</label>
        <input type="text" readonly class="form-control" value="{{ $application->user->email }}">
    </div>
</div>

<div class="form-row">
    <div class="form-group col-md-6">
        <label>User registered</label>
        <input
        type="text"
        readonly
        class="form-control"
        value="{{ $application->user->created_at->toDayDateTimeString() }}">
    </div>
    <div class="form-group col-md-6">
        <label>Application submitted</label>
        <input
        type="text"
        readonly
        class="form-control"
        value="{{ $application->user->created_at->toDayDateTimeString() }}">
    </div>
</div>

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

<div class="d-flex">
    <form method="post" action="{{ route('admin.applications.update', $application) }}">
        @method('patch')
        @csrf
        <input type="hidden" name="status" value="approved">
        <button type="submit" class="btn btn-success mr-2">
            Approve<i class="fas fa-check ml-3"></i>
        </button>
    </form>

    <form method="post" action="{{ route('admin.applications.update', $application) }}">
        @method('patch')
        @csrf
        <input type="hidden" name="status" value="rejected">
        <button type="submit" class="btn btn-danger">
            Reject<i class="fas fa-times ml-3"></i>
        </button>
    </form>
</div>

@endsection
