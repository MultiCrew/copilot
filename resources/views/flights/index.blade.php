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
                    <th style="width: 30%">User</th>
                    <th style="width: 15%">Departure</th>
                    <th style="width: 15%">Arrival</th>
                    <th style="width: 15%">Aircraft</th>
                    <th style="width: 25%"></th>
                </tr>
            </thead>

            <tbody>
                @foreach ($flights as $flight)
                    <tr>
                        <td class="align-middle">{{ User::find($flight->requestee_id)->username }}</td>
                        <td class="align-middle">
                            {{ is_array($flight->departure) ? implode(', ', $flight->departure) : 'No preference' }}
                        </td>
                        <td class="align-middle">
                            {{ is_array($flight->arrival) ? implode(', ', $flight->arrival) : 'No preference' }}
                        </td>
                        <td class="align-middle">{{ $flight->aircraft }}</td>
                        <td class="p-0 align-middle text-right">
                            <a
                            href="{{route('flights.accept', ['id' => $flight->id])}}"
                            class="btn btn-sm m-2 btn-success">
                                Accept &raquo;
                            </a>
                        </td>
                    </tr>
                @endforeach

                @if(!count($flights))
                    <tr>
                        <td colspan="5">No flights!</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

@include('flights.create')

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        if(window.location.href.indexOf('#createRequestModal') != -1) {
            $('#createRequestModal').modal('show');
        }
    });

    @if (count($errors) > 0)
        $('#createRequestModal').modal('show');
    @endif
</script>
@endsection
