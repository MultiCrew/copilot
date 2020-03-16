@extends('layouts.base')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">My Requests</h5>

        <ul class="nav nav-tabs card-text" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#open-requests" role="tab">
                    <i class="fas fa-fw mr-2 fa-plus"></i>Open Requests
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#accepted-requests" role="tab">
                    <i class="fas fa-fw mr-2 fa-check"></i>Accepted Requests
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#logbook" role="tab">
                    <i class="fas fa-fw mr-2 fa-book"></i>Logbook
                </a>
            </li>
        </ul>

        <div class="tab-content card-text" id="myTabContent">
            <div class="tab-pane fade show active" id="open-flights" role="tabpanel">
                <table class="table table-hover border mb-2">
                    <thead class="thead-light">
                        <tr>
                            <th>Departure</th>
                            <th>Arrival</th>
                            <th>Aircraft</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($openRequests as $flight)
                            <tr>
                                <td class="align-middle">{{ $flight->departure }}</td>
                                <td class="align-middle">{{ $flight->arrival }}</td>
                                <td class="align-middle">{{ $flight->aircraft }}</td>
                                <td class="align-middle text-right">
                                    <a href="{{ route('flights.show', $flight) }}" class="btn btn-sm btn-info">
                                        View Flight<i class="fas fa-fw ml-2 fa-angle-double-right"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        @if(!count($openRequests))
                            <tr>
                                <td class="text-center lead p-2" colspan="4">
                                    You have no open flights. Maybe you want to
                                    <a href="#">create a new one</a>?
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <div class="tab-pane fade" id="accepted-flights" role="tabpanel">
                <table class="table table-hover border">
                    <thead class="thead-light">
                        <tr>
                            <th>Copilot</th>
                            <th>Departure</th>
                            <th>Arrival</th>
                            <th>Aircraft</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($acceptedRequests as $flight)
                            <tr>
                                <td class="align-middle">
                                    @if($flight->acceptee_id === Auth::id())
                                        <a href="#" class="text-decoration-none">
                                            <i class="fas fa-fw mr-1 fa-xs fa-user-circle"></i>
                                            {{ User::find($flight->acceptee_id)->username }}
                                        </a>
                                    @else
                                        <a href="#" class="text-decoration-none">
                                            <i class="fas fa-fw mr-1 fa-xs fa-user-circle"></i>
                                            {{ User::find($flight->flightee_id)->username }}
                                        </a>
                                    @endif
                                </td>
                                <td class="align-middle">{{ $flight->departure }}</td>
                                <td class="align-middle">{{ $flight->arrival }}</td>
                                <td class="align-middle">{{ $flight->aircraft }}</td>
                                <td class="align-middle text-right">
                                    @if($flight->plan)
                                        <a href="{{ route('dispatch.show', $flight->plan) }}" class="btn btn-sm btn-success">
                                            <i class="fas fa-fw mr-2 fa-search"></i>@if($flight->plan->isApproved()) View Plan @else Review Plan @endif
                                        </a>
                                    @else
                                        <a href="{{ route('dispatch.create', $flight) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-fw mr-2 fa-file-signature"></i>Create Plan
                                        </a>
                                    @endif

                                    <a href="{{ route('flights.show', $flight) }}" class="btn btn-sm btn-info">
                                        View<i class="fas fa-fw ml-2 fa-angle-double-right"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        @if(!count($acceptedRequests))
                            <tr>
                                <td class="text-center">
                                    You have no accepted flights. Maybe you want to
                                    <a href="{{ route('flights.index') }}#">search open flights</a>?
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <div class="tab-pane fade" id="logbook" role="tabpanel">
                <h5>To do</h5>
            </div>
        </div>
    </div>
</div>

@include('flights.create')

@endsection
