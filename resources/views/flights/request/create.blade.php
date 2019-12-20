@extends('layouts.base')

@section('content')

    <form method="post" action="/flights">
        @csrf

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="departure">Departure</label>
                <input type="text" name="departure" id="departure" class="form-control">
            </div>

            <div class="form-group col-md-6">
                <label for="arrival">Arrival</label>
                <input type="text" name="arrival" id="arrival" class="form-control">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="aircraft">Aircraft</label>
                <input type="text" name="aircraft" id="aircraft" class="form-control">
            </div>
            <div class="form-group col-md-6">
                <div class="custom-control custom-switch">
                <label class="custom-control-label" for="public">Public flight toggle</label>
                <input type="checkbox" class="custom-control-input" id="public">
              </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Add <i class="fas fa-plus fa-fw ml-2"></i></button>
    </form>

@endsection

@section('scripts')

@endsection
