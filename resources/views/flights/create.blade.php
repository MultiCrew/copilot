@extends('layouts.base')

@section('content')

<form method="post" action="/flights">
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

    <div class="form-group">
        <label for="aircraft">Aircraft</label>
        <input type="text" name="aircraft" id="aircraft" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary">Add <i class="fas fa-plus fa-fw ml-2"></i></button>

</form>

@endsection
