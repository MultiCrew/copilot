@extends('layouts.base')

@section('content')

<div class="card">
    <form method="post" action="/flights/{{ $flight->id }}" class="card-body">
        @csrf
        @method('put')

        <div class="d-flex justify-content-between align-items-baseline">
            <h3 class="card-title">Edit Flight</h3>
            <a href="/flights/{{ $flight->id }}" class="btn btn-secondary mb-3 card-text">
                &times; Cancel
            </a>
        </div>

        <div class="form-group row card-text">
            <label class="col-sm-2 col-form-label" for="departure">Departure</label>
            <div class="col-sm-10">
                <input
                type="text"
                name="departure"
                id="departure"
                class="form-control"
                placeholder="Departure"
                required
                value="{{ $flight->departure }}">
            </div>
        </div>
        <div class="form-group row card-text">
            <label class="col-sm-2 col-form-label" for="arrival">Arrival</label>
            <div class="col-sm-10">
                <input
                type="text"
                name="arrival"
                id="arrival"
                class="form-control"
                placeholder="Arrival"
                required
                value="{{ $flight->arrival }}">
            </div>
        </div>
        <div class="form-group row card-text">
            <label class="col-sm-2 col-form-label" for="aircraft">Aircraft</label>
            <div class="col-sm-10">
                <input
                type="text"
                name="aircraft"
                id="aircraft"
                class="form-control"
                placeholder="Aircraft"
                required
                value="{{ $flight->aircraft }}">
            </div>
        </div>

        <div class="form-group align-self-center card-text">
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

        <button type="submit" class="btn btn-success card-text">
            <i class="fas fa-save fa-fw mr-2"></i>Save
        </button>
        <button
        type="button"
        class="btn btn-danger card-text"
        data-toggle="modal"
        data-target="#deleteModal">
            <i class="fas fa-trash fa-fw mr-2"></i>Delete
        </button>
    </form>
</div>

<div
class="modal fade"
id="deleteModal"
tabindex="-1"
role="dialog"
aria-labelledby="deleteModalLabel"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Delete flight</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this flight?
            </div>
            <div class="modal-footer">
                <form action="{{ route('flights.destroy', ['flight' => $flight]) }}" method="post">
                    @csrf
                    @method('delete')

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-2"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash mr-2"></i>Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
