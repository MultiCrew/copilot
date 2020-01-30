@extends('layouts.base')

@section('content')

<form method="post" action="/flights" class="w-50">
    @csrf
    @method('patch')

    <div class="d-flex justify-content-between align-items-baseline">
        <h3>Edit Flight</h3>
        <a href="/flights/{{ $flight->id }}" class="btn btn-secondary mb-3">
            &times; Cancel
        </a>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="departure">Departure</label>
        <input
        type="text"
        name="departure"
        id="departure"
        class="form-control col-sm-10"
        placeholder="Departure"
        required
        value="{{ $flight->departure }}">
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="arrival">Arrival</label>
        <input
        type="text"
        name="arrival"
        id="arrival"
        class="form-control col-sm-10"
        placeholder="Arrival"
        required
        value="{{ $flight->arrival }}">
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="aircraft">Aircraft</label>
        <input
        type="text"
        name="aircraft"
        id="aircraft"
        class="form-control col-sm-10"
        placeholder="Aircraft"
        required
        value="{{ $flight->aircraft }}">
    </div>

    <div class="form-group align-self-center">
        <div class="custom-control custom-switch">
            <input
            type="checkbox"
            class="custom-control-input"
            id="public"
            name="public"
            @if($flight->public) checked @endif>
            <label class="custom-control-label" for="public">Public flight</label>
        </div>
    </div>

    <button type="submit" class="btn btn-success">
        Save <i class="fas fa-save fa-fw ml-2"></i>
    </button>
</form>

@endsection
