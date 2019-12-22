@extends('layouts.base')

@section('content')

<div class="card">
    <div class="card-body">
        <h5 class="card-title">
            @if(isset($title))
                {{ $title }}
            @else
                Flights
            @endif
        </h5>

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
                                <a href="{{route('flights.accept', ['id' => $flight->id])}}" class="btn btn-sm m-2 btn-success">
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

@endsection
