@extends('layouts.base')

@section('content')
<div class="card">
    <div class="card-body">
        <
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
            <div class="tab-pane fade show active" id="open-requests" role="tabpanel">
                <table class="table table-hover border mb-2">
                    <thead class="thead-light">
                        <tr class="d-flex">
                            <th class="col-3">Departure</th>
                            <th class="col-3">Arrival</th>
                            <th class="col-3">Aircraft</th>
                            <th class="col-3"></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($openRequests as $request)
                            <tr>
                                <td class="align-middle">{{ $request->departure }}</td>
                                <td class="align-middle">{{ $request->arrival }}</td>
                                <td class="align-middle">{{ $request->aircraft }}</td>
                                <td class="align-middle">
                                    <a href="{{ route('flights.show', $request) }}" class="btn btn-sm btn-info">
                                        View<i class="fas fa-fw ml-2 fa-angle-double-right"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        @if(!count($openRequests))
                            <tr>
                                <td class="text-center lead p-2">
                                    You have no open requests. Maybe you want to
                                    <a href="#">create a new one</a>?
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <div class="tab-pane fade" id="accepted-requests" role="tabpanel">
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
                        @foreach($acceptedRequests as $request)
                            <tr>
                                <td class="align-middle">
                                    @if($request->acceptee_id === Auth::id())
                                        <a href="#" class="text-decoration-none">
                                            <i class="fas fa-fw mr-1 fa-xs fa-user-circle"></i>
                                            {{ User::find($request->acceptee_id)->username }}
                                        </a>
                                    @else
                                        <a href="#" class="text-decoration-none">
                                            <i class="fas fa-fw mr-1 fa-xs fa-user-circle"></i>
                                            {{ User::find($request->requestee_id)->username }}
                                        </a>
                                    @endif
                                </td>
                                <td class="align-middle">{{ $request->departure }}</td>
                                <td class="align-middle">{{ $request->arrival }}</td>
                                <td class="align-middle">{{ $request->aircraft }}</td>
                                <td class="align-middle">
                                    <a href="{{ route('flights.show', $request) }}" class="btn btn-sm btn-info">
                                        View<i class="fas fa-fw ml-2 fa-angle-double-right"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        @if(!count($acceptedRequests))
                            <tr>
                                <td class="text-center">
                                    You have no accepted requests. Maybe you want to
                                    <a href="{{ route('flights.index') }}#">search open requests</a>?
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

@endsection
