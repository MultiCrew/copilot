@extends('layouts.base')

@section('content')

<div class="card mb-4">
    <div class="card-body">
        <div class="float-right">
            <a class="btn btn-secondary" href="{{ url()->previous() }}">
                <i class="fas fa-fw mr-2 fa-angle-double-left"></i>Back
            </a>
        </div>
        <h3 class="card-title">Dispatch Flight</h3>

        <div class="row">
            <div class="col-md-9">
                <p class="card-text text-justify">
                    Please upload your existing plan in PDF format. No other file formats are accepted!
                </p>
                <p class="card-text text-justify">
                    If you do not have a PDF, you may wish to <a href="{{ route('dispatch.create', $flight) }}">plan this
                    flight using SimBrief</a>.
                </p>
            </div>

            <div class="col-md-3">
                <div class="form-group text-right card-text">
                    <label>Current UTC Time</label>
                    <input type="text" id="time" class="form-control text-right" readonly value="">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="alert alert-warning border">
            Your plan PDF will be uploaded to the MultiCrew web server, where it could be accessible by anyone on the
            Internet. Please make sure your PDF does not contain sensitive/personal information!
        </div>

        <form method="POST" action="{{ route('dispatch.store.upload') }}" enctype="multipart/form-data">
            @csrf

            <div class="custom-file card-text mb-3">
                <input type="file" name="plan" class="custom-file-input" id="plan">
                <label class="custom-file-label" for="plan">Choose file</label>
            </div>

            <p>
                Note that by uploading your own PDF instead of generating a full plan with our Dispatcher through
                SimBrief, you will not get the same summary and export features.
            </p>

            <input type="hidden" name="flight" value="{{ $flight->id }}">

            <button type="submit" class="btn btn-primary">
                Submit<i class="fas fa-angle-double-right ml-2"></i>
            </button>
        </form>
    </div>
</div>

@endsection
