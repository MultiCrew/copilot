@extends('layouts.base')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">My Requests</h5>

        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item">
                <a
                class="nav-link active"
                id="open-requests-tab"
                data-toggle="tab"
                href="#open-requests"
                role="tab">
                    <i class="fas fa-fw mr-2 fa-plus"></i>Open Requests
                </a>
            </li>
            <li class="nav-item">
                <a
                class="nav-link"
                id="accepted-requests-tab"
                data-toggle="tab"
                href="#accepted-requests"
                role="tab">
                    <i class="fas fa-fw mr-2 fa-check"></i>Accepted Requests
                </a>
            </li>
            <li class="nav-item">
                <a
                class="nav-link"
                id="logbook-tab"
                data-toggle="tab"
                href="#logbook"
                role="tab">
                    <i class="fas fa-fw mr-2 fa-book"></i>Logbook
                </a>
            </li>
        </ul>

        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="open-requests" role="tabpanel">
                <table class="table table-hover border card-text">
                    <thead class="thead-light">
                        <tr>
                            <th>Departure</th>
                            <th>Arrival</th>
                            <th>Aircraft</th>

                            <th class="text-right p-2">
                                <button type="button" class="btn btn-primary btn-sm m-0" data-toggle="modal" data-target="#createRequestModal">
                                    <i class="fas fa-fw mr-2 fa-plus"></i> New Request
                                </button>
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($openRequests as $flight)
                            <tr>
                                <td class="align-middle">
                                    {{ is_array($flight->departure) ? implode(', ', $flight->departure) : 'No preference' }}
                                </td>
                                <td class="align-middle">
                                    {{ is_array($flight->arrival) ? implode(', ', $flight->arrival) : 'No preference' }}
                                </td>

                                <td class="align-middle">{{ $flight->aircraft }}</td>
                                <td class="align-middle text-right">
                                    <a href="{{ route('flights.show', $flight) }}" class="btn btn-sm btn-info">
                                        View Flight<i class="fas fa-fw ml-2 fa-angle-double-right"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center lead p-2" colspan="4">
                                    You have no open flights. Maybe you want to
                                    <a href="#" data-toggle="modal" data-target="#createRequestModal">create a new one</a>?
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="tab-pane fade" id="accepted-requests" role="tabpanel">
                <table class="table table-hover border card-text">
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
                        @forelse($acceptedRequests as $flight)
                            <tr>
                                <td class="align-middle">
                                    <a href="#" class="text-decoration-none">
                                        <i class="fas fa-fw mr-1 fa-xs fa-user-circle"></i>
                                        {{ $flight->otherUser()->username }}
                                    </a>
                                </td>

                                <td class="align-middle">
                                    {{ is_array($flight->departure) ? implode(', ', $flight->departure) : 'No preference' }}
                                </td>
                                <td class="align-middle">
                                    {{ is_array($flight->arrival) ? implode(', ', $flight->arrival) : 'No preference' }}
                                </td>

                                <td class="align-middle">{{ $flight->aircraft }}</td>

                                <td class="align-middle text-right">
                                    <a href="{{ route('flights.show', $flight) }}" class="btn btn-sm btn-info">
                                        View<i class="fas fa-fw ml-2 fa-angle-double-right"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center lead p-2">
                                    You have no accepted flights. Maybe you want to
                                    <a href="{{ route('flights.index') }}#">search open flights</a>?
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="tab-pane fade" id="logbook" role="tabpanel">
                <table class="table table-hover border card-text">
                    <thead class="thead-light">
                        <tr>
                            <th>Date</th>
                            <th>Departure</th>
                            <th>Arrival</th>
                            <th>Aircraft</th>
                            <th>Copilot</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($archivedFlights as $flight)
                            <tr>
                                <td class="align-middle">
                                    {{ \Carbon\Carbon::parse($flight->created_at)
                                        ->format('H:i, D j M Y') }}
                                </td>
                                <td class="align-middle">
                                    {{ $flight->departure }}
                                </td>
                                <td class="align-middle">
                                    {{ $flight->arrival }}
                                </td>
                                <td class="align-middle">
                                    {{ $flight->aircraft }}
                                </td>
                                <td class="align-middle">
                                    <a href="#" class="text-decoration-none">
                                        <i class="fas fa-fw mr-1 fa-xs fa-user-circle"></i>
                                        {{ $flight->otherUser()->username }}
                                    </a>
                                </td>
                                <td class="align-middle text-right">
                                    <a
                                    href="{{ route('flights.archive.show', $flight) }}"
                                    class="btn btn-primary btn-sm">
                                        View<i class="fas fa-fw ml-2 fa-angle-double-right"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">No flights!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
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
