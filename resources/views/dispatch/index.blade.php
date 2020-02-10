@extends('layouts.base')

@section('content')

<div class="card mb-4">
    <div class="card-body">
        <h5 class="card-title">
            <i class="fas fa-map-marked-alt fa-fw mr-2"></i>Your Current Plans
        </h5>
        <p class="card-text lead text-muted">
            These flight plans are either being reviewed, or are ready for use in the sim.
        </p>

        <table class="table table-hover card-text border">
            <thead class="thead-light">
                <tr class="d-flex">
                    <th class="col-3">Copilot</th>
                    <th class="col-2">Departure</th>
                    <th class="col-2">Arrival</th>
                    <th class="col-2">Aircraft</th>
                    <th class="col-3"></th>
                </tr>
            </thead>

            <tbody>
                @foreach($plannedFlights as $flight)
                    <tr class="d-flex">
                        <td class="col-3">
                            @if($flight->requestee_id != Auth::id())
                                {{ $flight->requestee->username }}
                            @else
                                {{ $flight->acceptee->username }}
                            @endif
                        </td>
                        <td class="col-2">{{ $flight->departure }}</td>
                        <td class="col-2">{{ $flight->arrival }}</td>
                        <td class="col-2">{{ $flight->aircraft }}</td>
                        <td class="py-0 col-3 text-right">
                            <a href="{{ route('flights.show', [$flight->id]) }}" class="btn btn-sm my-2 btn-info">
                                Flight Details<i class="fas fa-fw ml-2 fa-search"></i>
                            </a>

                            @if($flight->plan->isApproved())
                                <a href="{{ route('dispatch.show', [$flight->plan_id]) }}" class="btn btn-sm my-2 btn-success">
                                    View Plan<i class="fas fa-fw ml-2 fa-angle-double-right"></i>
                                </a>
                            @else
                                <a href="{{ route('dispatch.show', [$flight->plan_id]) }}" class="btn btn-sm my-2 btn-warning">
                                    Review Plan<i class="fas fa-fw ml-2 fa-angle-double-right"></i>
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach

                @if(!count($plannedFlights))
                    <tr>
                        <td colspan="5">No flights!</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body">
        <h5 class="card-title">
            <i class="fas fa-file-signature fa-fw mr-2"></i>Unplanned Flights
        </h5>
        <p class="card-text lead text-muted">
            These flights are ready to go, but don't have a flight plan yet. Create one now!
        </p>

        <table class="table table-hover card-text border">
            <thead class="thead-light">
                <tr class="d-flex">
                    <th class="col-3">Copilot</th>
                    <th class="col-2">Departure</th>
                    <th class="col-2">Arrival</th>
                    <th class="col-2">Aircraft</th>
                    <th class="col-3"></th>
                </tr>
            </thead>

            <tbody>
                @foreach($unplannedFlights as $flight)
                    <tr class="d-flex">
                        <td class="col-3">
                            @if($flight->requestee_id != Auth::id())
                                {{ $flight->requestee->username }}
                            @else
                                {{ $flight->acceptee->username }}
                            @endif
                        </td>
                        <td class="col-2">{{ $flight->departure }}</td>
                        <td class="col-2">{{ $flight->arrival }}</td>
                        <td class="col-2">{{ $flight->aircraft }}</td>
                        <td class="py-0 col-3 text-right">
                            <a href="{{ route('flights.show', [$flight->id]) }}" class="btn btn-sm my-2 btn-info">
                                Flight Details<i class="fas fa-fw ml-2 fa-search"></i>
                            </a>
                            <a href="{{ route('dispatch.create', [$flight->id]) }}" class="btn btn-sm my-2 btn-success">
                                Create Plan<i class="fas fa-fw ml-2 fa-angle-double-right"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach

                @if(!count($unplannedFlights))
                    <tr>
                        <td colspan="5">No flights!</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

@endsection
