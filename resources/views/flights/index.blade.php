@extends('layouts.base')

@section('content')

<div class="card">
    <div class="card-body">
        <div class="card-title mb-0 d-flex justify-content-between align-items-baseline">
            <h5 class="card-title">
                @if(isset($title))
                    {{ $title }}
                @else
                    Flights
                @endif
            </h5>
            <p class="card-title">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createRequestModal">
                    <i class="fas fa-fw mr-2 fa-plus"></i> New Request
                </button>
            </p>
        </div>

        <table class="table table-hover card-text border">
            <thead class="thead-light">
                <tr>
                    <th>User</th>
                    <th>Departure</th>
                    <th>Arrival</th>
                    <th>Aircraft</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                @foreach ($flights as $flight)
                    @if($flight->public)
                        <tr>
                            <td>{{ App\Models\Users\User::find($flight->requestee_id)->username }}</td>
                            <td>{{ $flight->departure }}</td>
                            <td>{{ $flight->arrival }}</td>
                            <td>{{ $flight->aircraft }}</td>
                            <td class="p-0">
                                <a
                                href="{{route('flights.accept', ['id' => $flight->id])}}"
                                class="btn btn-sm m-2 btn-success">
                                    Accept &raquo;
                                </a>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
</div>


<div
class="modal fade"
id="createRequestModal"
tabindex="-1"
role="dialog"
aria-labelledby="createRequestModalLabel"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title" id="createRequestModalLabel">Create Request</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group mr-2">
                        <label class="sr-only" for="departure">Departure</label>
                        <input
                        type="text"
                        name="departure"
                        id="departure"
                        class="form-control"
                        placeholder="Departure"
                        required>
                    </div>
                    <div class="form-group mr-2">
                        <label class="sr-only" for="arrival">Arrival</label>
                        <input
                        type="text"
                        name="arrival"
                        id="arrival"
                        class="form-control"
                        placeholder="Arrival"
                        required>
                    </div>
                    <div class="form-group mr-2">
                        <label class="sr-only" for="aircraft">Aircraft</label>
                        <input
                        type="text"
                        name="aircraft"
                        id="aircraft"
                        class="form-control"
                        placeholder="Aircraft"
                        required>
                    </div>

                    <div class="form-group align-self-center">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="public" name="public">
                            <label class="custom-control-label" for="public">Public flight</label>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">
                        Submit <i class="fas fa-angle-double-right fa-fw ml-2"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        if(window.location.href.indexOf('#createRequestModal') != -1) {
            $('#createRequestModal').modal('show');
        }
    });
</script>
@endsection
