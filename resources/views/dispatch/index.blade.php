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
                            {{ $flight->otherUser()->username }}
                        </td>
                        <td class="col-2">{{ $flight->departure }}</td>
                        <td class="col-2">{{ $flight->arrival }}</td>
                        <td class="col-2">{{ $flight->aircraft }}</td>
                        <td class="py-0 col-3 text-right">
                            <a href="{{ route('flights.show', [$flight->id]) }}" class="btn btn-sm my-2 btn-secondary">
                                Flight Details<i class="fas fa-fw ml-2 fa-search"></i>
                            </a>

                            <a href="{{ route('dispatch.show', [$flight->plan_id]) }}" class="btn btn-sm my-2 btn-primary">
                                @unless($flight->plan->isApproved()) Review @else View @endunless
                                Plan<i class="fas fa-fw ml-2 fa-angle-double-right"></i>
                            </a>
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
                            {{ $flight->otherUser()->username }}
                        </td>
                        <td class="col-2">{{ $flight->departure }}</td>
                        <td class="col-2">{{ $flight->arrival }}</td>
                        <td class="col-2">{{ $flight->aircraft }}</td>
                        <td class="py-0 col-3 text-right">
                            <a href="{{ route('flights.show', [$flight->id]) }}" class="btn btn-sm my-2 btn-secondary">
                                Flight Details<i class="fas fa-fw ml-2 fa-search"></i>
                            </a>

                            <button
                            type="button"
                            class="btn btn-sm btn-primary my-2"
                            data-toggle="modal"
                            data-target="#dispatchModal"
                            onclick="updateModal({{ $flight->id }})">
                                Dispatch<i class="fas fa-fw ml-2 fa-angle-double-right"></i>
                            </button>
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

<div
class="modal fade"
id="dispatchModal"
tabindex="-1"
role="dialog"
aria-labelledby="dispatchModalLabel"
aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dispatchModalLabel">Dispatch Flight</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="lead text-center">Select how you want to dispatch this flight</p>
                <a href="#" class="btn btn-lg btn-block btn-primary" disabled>
                    <i class="fas fa-file-upload mr-2"></i>Upload PDF Plan
                </a>
                <a href="#" class="btn btn-lg btn-block btn-primary" id="dispatchSimbriefButton">
                    <i class="fas fa-file-contract mr-2"></i>Create SimBrief Plan
                </a>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times mr-2"></i>Close
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')

<script type="text/javascript">
    function updateModal(id)
    {
        var url = "{{ route('dispatch.create', ':id') }}"
        url = url.replace(':id', id);
        $('#dispatchSimbriefButton').attr('href', url);
    }
</script>

@endsection
